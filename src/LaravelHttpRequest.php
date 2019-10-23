<?php

namespace Submtd\LaravelHttpRequest;

use Submtd\HttpRequest\HttpRequest;
use Http\Client\Common\HttpMethodsClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\HttpClientDiscovery;

class LaravelHttpRequest extends HttpRequest implements \Serializable
{
    /**
     * tries
     */
    protected $tries;

    /**
     * delay between failed attempts
     */
    protected $delayBetweenFails;

    /**
     * queues the request
     */
    public function queue()
    {
        QueuedHttpRequest::dispatch($this);
    }

    /**
     * get tries
     * @return int
     */
    public function getTries()
    {
        return $this->tries ?? config('laravel-http-request.defaultNumberOfTriesForQueuedRequests', 1);
    }

    /**
     * set tries
     * @param int $tries
     * @return Submtd\LaravelHttpRequest\LaravelHttpRequest
     */
    public function tries(int $tries)
    {
        $this->tries = $tries;
        return $this;
    }

    /**
     * get delay between fails
     * @return int
     */
    public function getDelayBetweenFails()
    {
        return $this->delayBetweenFails ?? config('laravel-http-request.defaultDelayBetweenFailedAttempts', 60);
    }

    /**
     * set delay between fails
     * @param int $delay
     * @return Submtd\\LaravelHttpRequest\LaravelHttpRequest
     */
    public function delayBetweenFails(int $delay)
    {
        $this->delayBetweenFails = $delay;
        return $this;
    }

    public function serialize()
    {
        return serialize([
            'method' => $this->getMethod(),
            'url' => $this->getUrl(),
            'headers' => $this->getHeaders(),
            'body' => $this->getBody(),
            'statusCode' => $this->getStatusCode(),
            'response' => $this->getResponse(),
        ]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->client = new HttpMethodsClient(HttpClientDiscovery::find(), MessageFactoryDiscovery::find());
        $this->method = $data['method'];
        $this->url = $data['url'];
        $this->headers = $data['headers'];
        $this->body = $data['body'];
        $this->statusCode = $data['statusCode'];
        $this->response = $data['response'];
    }
}
