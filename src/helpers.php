<?php

if (!function_exists('http')) {
    function http(\Http\Client\HttpClient $client = null, \Http\Message\MessageFactory $messageFactory = null)
    {
        return \Submtd\LaravelHttpRequest\LaravelHttpRequest::init();
    }
}
