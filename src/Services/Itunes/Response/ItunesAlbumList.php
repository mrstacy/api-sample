<?php

namespace App\Services\Itunes\Response;

class ItunesAlbumList extends ItunesRssResponse
{
    const LINK_TYPE_RSS = 'self';
    const LINK_TYPE_HTML = 'alternate';

    const LIST_TOP_100_ID = 'top100';

    public function getAuthor()
    {
        return $this->payload->author->name->label ?? '';
    }

    public function getAuthorUrl()
    {
        return $this->payload->author->uri->label ?? '';
    }

    /**
     * @return ItunesAlbum[]
     */
    public function getAlbums()
    {
        return ItunesAlbum::buildResponseObjectsFromArray($this->payload->entry);
    }

    public function getUpdateDate()
    {
        return $this->payload->updated->label ?? '';
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedDateTime()
    {
        return new \DateTime($this->getUpdateDate());
    }

    public function getRights()
    {
        return $this->payload->rights->label ?? '';
    }

    public function getTitle()
    {
        return $this->payload->title->label ?? '';
    }

    public function getIcon()
    {
        return $this->payload->icon->label ?? '';
    }

    public function getLinks()
    {
        return $this->payload->link ?? [];
    }

    public function getLink()
    {
        foreach ( $this->getLinks() as $link ) {
            $type = $link->attributes->rel ?? 'unknown';
            if ( $type == self::LINK_TYPE_HTML ) {
                return $link->attributes->href;
            }
        }
    }

    public function getRSSLink()
    {
        // NOTE: This maybe incorrect as it doesn't seem to accessible, need to look into further
        foreach ( $this->getLinks() as $link ) {
            $type = $link->attributes->rel ?? 'unknown';
            if ( $type == self::LINK_TYPE_RSS ) {
                return $link->attributes->href;
            }
        }
    }

    public function getId()
    {
        // TODO: ID seems to be a variable url.. we need to do some parsing and come up with a better way to determine a list id
        // https://mzstoreservices-int-st.itunes.apple.com/us/rss/topalbums/limit=100/json
        // https://mzstoreservices-int.dslb.apple.com/us/rss/topalbums/limit=100/json
        // For now lets just make it a top 100 list ID
        //return $this->payload->label ?? '';
        return self::LIST_TOP_100_ID;
    }

}

