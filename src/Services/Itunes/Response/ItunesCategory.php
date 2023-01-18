<?php

namespace App\Services\Itunes\Response;

/*
{
"im:id":"16",
"term":"Soundtrack",
"scheme":"https://music.apple.com/us/genre/music-soundtrack/id16?uo=2",
"label":"Soundtrack"
}
*/
class ItunesCategory extends ItunesRssResponse
{
    public function getId()
    {
        return $this->payload->{'im:id'} ?? null;
    }

    public function getTerm()
    {
        return $this->payload->term ?? null;
    }

    public function getScheme()
    {
        return $this->payload->scheme ?? null;
    }

    public function getLabel()
    {
        return $this->payload->label ?? null;
    }
}