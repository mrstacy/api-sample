<?php

namespace App\Services\Itunes\Response;

   /*
      {
        "im:name":{
          "label":"Roald Dahl's Matilda The Musical (Soundtrack from the Netflix Film)"
        },
        "im:image":[
          {
            "label":"https://is5-ssl.mzstatic.com/image/thumb/Music112/v4/be/3d/69/be3d6915-653d-c45c-0077-1c626e78b539/196589602411.jpg/55x55bb.png",
            "attributes":{
              "height":"55"
            }
          },
          {
            "label":"https://is2-ssl.mzstatic.com/image/thumb/Music112/v4/be/3d/69/be3d6915-653d-c45c-0077-1c626e78b539/196589602411.jpg/60x60bb.png",
            "attributes":{
              "height":"60"
            }
          },
          {
            "label":"https://is4-ssl.mzstatic.com/image/thumb/Music112/v4/be/3d/69/be3d6915-653d-c45c-0077-1c626e78b539/196589602411.jpg/170x170bb.png",
            "attributes":{
              "height":"170"
            }
          }
        ],
        "im:itemCount":{
          "label":"22"
        },
        "im:price":{
          "label":"$10.99",
          "attributes":{
            "amount":"10.99",
            "currency":"USD"
          }
        },
        "im:contentType":{
          "im:contentType":{
            "attributes":{
              "term":"Album",
              "label":"Album"
            }
          },
          "attributes":{
            "term":"Music",
            "label":"Music"
          }
        },
        "rights":{
          "label":"℗ 2022 Netflix Music, LLC, under exclusive license to Masterworks, a label of Sony Music Entertainment"
        },
        "title":{
          "label":"Roald Dahl's Matilda The Musical (Soundtrack from the Netflix Film) - The Cast of Roald Dahl's Matilda The Musical"
        },
        "link":{
          "attributes":{
            "rel":"alternate",
            "type":"text/html",
            "href":"https://music.apple.com/us/album/roald-dahls-matilda-the-musical-soundtrack-from/1651697754?uo=2"
          }
        },
        "id":{
          "label":"https://music.apple.com/us/album/roald-dahls-matilda-the-musical-soundtrack-from/1651697754?uo=2",
          "attributes":{
            "im:id":"1651697754"
          }
        },
        "im:artist":{
          "label":"The Cast of Roald Dahl's Matilda The Musical",
          "attributes":{
            "href":"https://music.apple.com/us/artist/the-cast-of-roald-dahls-matilda-the-musical/1651697755?uo=2"
          }
        },
        "category":{
          "attributes":{
            "im:id":"16",
            "term":"Soundtrack",
            "scheme":"https://music.apple.com/us/genre/music-soundtrack/id16?uo=2",
            "label":"Soundtrack"
          }
        },
        "im:releaseDate":{
          "label":"2022-11-18T00:00:00-07:00",
          "attributes":{
            "label":"November 18, 2022"
          }
        }
      },
 */

class ItunesAlbum extends ItunesRssResponse
{
    public function getName()
    {
        return $this->payload->{'im:name'}->label ?? '';
    }

    public function getId()
    {
        return $this->payload->id->attributes->{'im:id'};
    }

    public function getImageIcon()
    {
        $images = $this->getImages();
        return end($images);
    }

    public function getImages() : array
    {
        $return = [];
        foreach ( $this->payload->{'im:image'} as $image ) {
            $return[] = $image->label;
        }
        return $return;
    }

    public function getPrice() : ?float
    {
        return $this->payload->{'im:price'}->attributes->amount ?? null;
    }

    // Album Song Count
    public function getItemCount() : int
    {
        return $this->payload->{'im:itemCount'}->label ?? 0;
    }

    public function getRights() : string
    {
        return $this->payload->rights->label ?? '';
    }

    public function getTitle() : string
    {
        return $this->payload->title->label ?? '';
    }

    public function getLink() : string
    {
        return $this->payload->link->attributes->href ?? '';
    }

    /**
     * @return ItunesArtist
     */
    public function getArtist()
    {
        return new ItunesArtist($this->payload->{'im:artist'});
    }

    /**
     * @return ItunesCategory
     */
    public function getCategory() : ItunesCategory
    {
        return new ItunesCategory($this->payload->category->attributes);
    }

    public function getReleaseDate()
    {
        return $this->payload->{'im:releaseDate'}->attributes->label ?? '';
    }

    public function getReleaseDateTime() : \DateTime
    {
        return new \DateTime($this->payload->{'im:releaseDate'}->label);
    }

}