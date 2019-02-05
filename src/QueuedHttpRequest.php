<?php

namespace Submtd\LaravelHttpRequest;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Bus\Queueable;

class QueuedHttpRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * request object
     */
    protected $request;

    /**
     * callback
     */
    protected $callback;

    /**
     * class constructor
     * @param Submtd\LaravelHttpRequest\LaravelHttpRequest $request
     * @param callable $callback
     */
    public function __construct(LaravelHttpRequest $request, callable $callback)
    {
        $this->request = $request;
        $this->callback = $callback;
    }

    /**
     * handle
     */
    public function handle()
    {
        try {
            call_user_func($this->callback, $this->request->request());
        } catch (\Exception $e) {
            if ($this->attempts() >= $this->request->getTries()) {
                $this->fail($e);
                return;
            }
            $this->release($this->attempts() * $this->request->getDelayBetweenFails());
        }
    }
}
