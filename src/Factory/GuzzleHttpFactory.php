<?php

namespace App\Factory;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class GuzzleHttpFactory
{
    protected $kernelEnv;

    /** @var Client */
    protected $client;

    public function __construct($kernelEnv)
    {
        $this->kernelEnv = $kernelEnv;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function create($config = [])
    {
        // allow tests to override the client
        if ( $this->client ) {
            return $this->client;
        }

        if ( $this->kernelEnv == "test" ) {
            $mock = new MockHandler([]);
            $handlerStack = HandlerStack::create($mock);
            return new Client(['handler' => $handlerStack]);
        }

        return new Client($config);
    }
}
