<?php

namespace App\Controller;

use App\Services\Itunes\ItunesRssService;
use App\Services\Itunes\Mapper\ItunesAlbumListToAlbumListMapper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ITunesController extends BaseController
{
    /** @var ItunesRssService  */
    protected $itunesService;

    public function __construct(ItunesRssService $itunesService)
    {
        $this->itunesService = $itunesService;
    }

    /**
     * @Route(
     *     methods={"GET"},
     *     path="/v1/itunes/albums",
     * )
     */
    public function getAlbums(Request $request)
    {
        $top100List = $this->itunesService->getTop100AlbumList();

        $mapper = new ItunesAlbumListToAlbumListMapper();
        $albumList = $mapper->map($top100List);


        return new JsonResponse($albumList);



print "<pre>";
        print json_encode(
            $albumList
        , JSON_PRETTY_PRINT);

        exit;



        $album = $top100List->getAlbums()[0];

        $artist = $album->getArtist();

        print $artist->getId();
        exit;


        //$blah = $top100List->getPayload();




        unset($blah->entry);

        print "<pre>";
        print_r($blah); exit;



        print_r($top100List->getAlbums()[0]);
        exit;

        //print "<pre>";
        //print_r($top100Albums); exit;

        return new JsonResponse([
            'test'
        ]);
    }

    public function refreshAlbums()
    {
        // pull albums from itunes, save to database
    }

    public function getAlbum(){}
    public function addAlbum(){}
    public function deleteAlbum(){}
    public function updateAlbum(){}



}