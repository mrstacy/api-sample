<?php

namespace App\Tests\Services\Itunes;

use App\Factory\GuzzleHttpFactory;
use App\Services\Itunes\ItunesRssService;
use App\Services\Itunes\Response\ItunesAlbumList;
use App\Tests\TestCase\WebTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ItunesRssServiceTest extends WebTestCase
{
    /** @group integration */
    public function testGetTop100AlbumList()
    {
        $guzzleFactory = $this->get(GuzzleHttpFactory::class);

        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . '/../../Mock/Itunes/top100.json')),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $guzzleFactory->setClient(new Client(['handler' => $handlerStack]));

        /** @var ItunesRssService $itunesRssService */
        $itunesRssService = $this->get(ItunesRssService::class);

        $top100 = $itunesRssService->getTop100AlbumList();

        self::assertEquals(ItunesAlbumList::class, get_class($top100));
        self::assertEquals(3, count($top100->getAlbums()));
    }

}