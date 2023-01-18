<?php

namespace App\Services\Itunes;

use App\Factory\GuzzleHttpFactory;
use App\Services\Itunes\Response\ItunesAlbumList;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\Config\Definition\Exception\Exception;

class ItunesRssService
{
    protected $apiUrl;

    /** @var GuzzleClient */
    protected $guzzleClient;

    public function __construct($itunesRssUrl, GuzzleHttpFactory $guzzleHttpFactory)
    {
        $this->apiUrl = $itunesRssUrl;
        $this->guzzleClient = $guzzleHttpFactory->create();
    }

    /**
     * @return ItunesAlbumList
     */
    public function getTop100AlbumList()
    {
        $response = $this->get('/topalbums/limit=100/json');

        if ( !isset($response->feed) ) {
            throw new Exception('Unexpected itunes RSS response');
        }

        return new ItunesAlbumList($response->feed);
    }

    protected function get($url)
    {
        return $this->getAPIResponse($url, 'GET');
    }

    protected function buildUrl($pathAndQuery)
    {
        $baseUrl = rtrim($this->apiUrl, '/');
        return $baseUrl . $pathAndQuery;
    }

    protected function getAPIResponse($pathAndQuery, $method = 'GET', $body = '')
    {
        $url = $this->buildUrl($pathAndQuery);
        $stringBody = is_array($body) ? json_encode($body) : $body;

        //try {
            $response = $this->guzzleClient->request($method, $url, [
                'body'=>$stringBody,
            ]);
        //} catch(GuzzleException $e) {
        //}

        return json_decode($response->getBody());
    }
}