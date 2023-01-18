<?php

namespace App\Services\Itunes\Response;

abstract class ItunesRssResponse implements \JsonSerializable
{
    protected $payload;

    public function __construct(\stdClass $payload)
    {
        $this->payload = $payload;
    }

    public function jsonSerialize() : mixed
    {
        return $this->payload;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public static function buildResponseObjectsFromArray($payloadArray, $class=null)
    {
        if ( !$class ) {
            $class = get_called_class();
        }

        $return = [];
        foreach ($payloadArray as $index=>$payload) {
            $return[] = new $class($payload);
        }

        return $return;
    }

}