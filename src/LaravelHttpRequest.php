<?php

namespace Submtd\LaravelHttpRequest;

use Submtd\HttpRequest\HttpRequest;

class LaravelHttpRequest extends HttpRequest
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
     * @param callable $callback
     */
    public function queue(callable $callback = null)
    {
        QueuedHttpRequest::dispatch($this, $callback);
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
}
