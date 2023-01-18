<?php

namespace App\Services\Itunes\Response;

/*
{
  "label":"The Cast of Roald Dahl's Matilda The Musical",
  "attributes":{
    "href":"https://music.apple.com/us/artist/the-cast-of-roald-dahls-matilda-the-musical/1651697755?uo=2"
  }
}
 */
class ItunesArtist extends ItunesRssResponse
{
    public function getUrl()
    {
        return $this->payload->attributes->href ?? '';
    }

    public function getId()
    {
        // NOTE: No actual ID is returned for the artist, for now making an assumption the number in the URL is the ID
        $url = $this->getUrl();
        preg_match('/\/([0-9]+?)\?/', $url, $matches);
        return $matches[1] ?? md5($url);
    }

    public function getName()
    {
        return $this->payload->label ?? '';
    }
}