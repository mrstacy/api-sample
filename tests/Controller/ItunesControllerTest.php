<?php

namespace App\Tests\Controller;

use App\Factory\GuzzleHttpFactory;
use App\Tests\TestCase\WebTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ItunesControllerTest extends WebTestCase
{
    /** @group integration */
    public function testGetAlbums()
    {
        $guzzleFactory = $this->get(GuzzleHttpFactory::class);

        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . '/../Mock/Itunes/top100.json')),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $guzzleFactory->setClient(new Client(['handler' => $handlerStack]));

        $headers = $this->getAuthHeaders();
        $client = $this->getTestClient();
        $client->request('GET', '/v1/itunes/albums', [], [], $headers);
        $content = json_decode($client->getResponse()->getContent());
print json_encode($content, JSON_PRETTY_PRINT); exit;


        self::assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertEquals('top100', $content->itune_id);
        self::assertEquals('iTunes Store: Top Albums', $content->name);
        self::assertEquals('2023-01-15T17:34:44-07:00', $content->itunes_last_updated);
        self::assertEquals('https://itunes.apple.com/WebObjects/MZStore.woa/wa/viewTop?cc=us&id=1&popId=11', $content->url);
        self::assertEquals('https://mzstoreservices-int-st.itunes.apple.com/us/rss/topalbums/limit=100/json', $content->rss_url);
        self::assertEquals(3, count($content->albums));
        self::assertEquals('158639291', $content->albums[0]->itune_id);
        self::assertEquals('Blow By Blow', $content->albums[0]->name);
        self::assertEquals('7.99', $content->albums[0]->price);
        self::assertEquals('9', $content->albums[0]->song_count);
        self::assertEquals('℗ 1975 Sony Music Entertainment Inc.', $content->albums[0]->rights);
        self::assertEquals('1110', $content->albums[0]->category->itunes_id);
        self::assertEquals('Fusion', $content->albums[0]->category->name);
        self::assertEquals('https://music.apple.com/us/genre/music-jazz-fusion/id1110?uo=2', $content->albums[0]->category->url);
        self::assertEquals('476310', $content->albums[0]->artist->itunes_id);
        self::assertEquals('Jeff Beck', $content->albums[0]->artist->name);
        self::assertEquals('https://music.apple.com/us/artist/jeff-beck/476310?uo=2', $content->albums[0]->artist->url);
    }

}