<?php

namespace App\Services\Itunes\Mapper;

use App\Entity\Album;
use App\Entity\AlbumList;
use App\Entity\Artist;
use App\Entity\Category;
use App\Services\Itunes\Response\ItunesAlbum;
use App\Services\Itunes\Response\ItunesAlbumList;
use App\Services\Itunes\Response\ItunesArtist;
use App\Services\Itunes\Response\ItunesCategory;

class ItunesAlbumListToAlbumListMapper
{
    protected $categoryLookup = [];
    protected $artistLookup = [];

    public function map(ItunesAlbumList $itunesAlbumList) : AlbumList
    {
        $this->categoryLookup = $this->buildCategories($itunesAlbumList);
        $this->artistLookup = $this->buildArtists($itunesAlbumList);

        $albumList = $this->mapAlbumList($itunesAlbumList, new AlbumList());

        foreach ( $itunesAlbumList->getAlbums() as $index=>$ituneAlbum ) {
            $rank = $index + 1;
            $album = $this->mapAlbum($ituneAlbum, new Album(), $rank);
            $albumList->addAlbum($album);
        }

        return $albumList;
    }

    /**
     * @param ItunesAlbumList $itunesAlbumList
     * @return Category[]
     */
    protected function buildCategories(ItunesAlbumList $itunesAlbumList)
    {
        $return = [];
        foreach ( $itunesAlbumList->getAlbums() as $ituneAlbum ) {
            $itunesCategory = $ituneAlbum->getCategory();

            if ( !isset($return[$itunesCategory->getId()]) ) {
                $return[$itunesCategory->getId()] = $this->mapCategory($itunesCategory, new Category());
            }
        }
        return $return;
    }

    protected function mapCategory(ItunesCategory $itunesCategory, Category $category)
    {
        $category->setItunesId($itunesCategory->getId());
        $category->setName($itunesCategory->getLabel());
        $category->setUrl($itunesCategory->getScheme());
        return $category;
    }

    protected function buildArtists(ItunesAlbumList $itunesAlbumList)
    {
        $return = [];
        foreach ( $itunesAlbumList->getAlbums() as $ituneAlbum ) {
            $itunesArtist = $ituneAlbum->getArtist();
            if ( !isset($return[$itunesArtist->getId()]) ) {
                $return[$itunesArtist->getId()] = $this->mapArtist($itunesArtist, new Artist());
            }
        }
        return $return;
    }

    protected function mapArtist(ItunesArtist $itunesArtist, Artist $artist) : Artist
    {
        if ( !$itunesArtist->getId() ) {
            print_r($itunesArtist->getPayload());
            exit;
        }

        $artist->setItunesId($itunesArtist->getId());
        $artist->setUrl($itunesArtist->getUrl());
        $artist->setName($itunesArtist->getName());
        return $artist;
    }

    protected function mapAlbumList(ItunesAlbumList $itunesAlbumList, AlbumList $albumList) : AlbumList
    {
        $albumList->setItuneId($itunesAlbumList->getId());
        $albumList->setName($itunesAlbumList->getTitle());
        $albumList->setUrl($itunesAlbumList->getLink());
        $albumList->setRssUrl($itunesAlbumList->getRSSLink());
        $albumList->setItunesLastUpdated($itunesAlbumList->getUpdatedDateTime());
        return $albumList;
    }

    protected function mapAlbum(ItunesAlbum $itunesAlbum, Album $album, $rank) : Album
    {
        // TODO: Map to AlbumListHasAlbum

        $album->setName($itunesAlbum->getName());
        $album->setArtist($this->artistLookup[$itunesAlbum->getArtist()->getId()]);
        $album->setCategory($this->categoryLookup[$itunesAlbum->getCategory()->getId()]);
        $album->setItuneId($itunesAlbum->getId());
        $album->setPrice($itunesAlbum->getPrice());
        $album->setReleaseDate($itunesAlbum->getReleaseDateTime());
        $album->setSongCount($itunesAlbum->getItemCount());
        $album->setRights($itunesAlbum->getRights());
        return $album;
    }

}
