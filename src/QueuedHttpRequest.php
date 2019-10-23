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
     * class constructor
     * @param Submtd\LaravelHttpRequest\LaravelHttpRequest $request
     */
    public function __construct(LaravelHttpRequest $request)
    {
        $this->request = $request;
    }

    /**
     * handle
     */
    public function handle()
    {
        try {
            $this->request->request();
        } catch (\Exception $e) {
            if ($this->attempts() >= $this->request->getTries()) {
                $this->fail($e);
                return;
            }
            $this->release($this->attempts() * $this->request->getDelayBetweenFails());
        }
    }
}
