<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\SerializerBuilder;

/**
 * @ORM\Table(name="album_list", indexes={
 * })
 * @ORM\Entity()
 */
class AlbumList implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", nullable=false)
     */
    protected int $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected string $ituneId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected string $name;

    protected \DateTime $itunesLastUpdated;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected string $url;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected string $rssUrl;

    /** @var AlbumListHasAlbum[] */
    //protected $albumListHasAlbums;

    /** @var ArrayCollection|Album[] */
    protected $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
        //$this->albumListHasAlbums = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getItuneId(): string
    {
        return $this->ituneId;
    }

    /**
     * @param string $ituneId
     */
    public function setItuneId(string $ituneId): void
    {
        $this->ituneId = $ituneId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return \DateTime
     */
    public function getItunesLastUpdated(): \DateTime
    {
        return $this->itunesLastUpdated;
    }

    /**
     * @param \DateTime $itunesLastUpdated
     */
    public function setItunesLastUpdated(\DateTime $itunesLastUpdated): void
    {
        $this->itunesLastUpdated = $itunesLastUpdated;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getRssUrl(): string
    {
        return $this->rssUrl;
    }

    /**
     * @param string $rssUrl
     */
    public function setRssUrl(string $rssUrl): void
    {
        $this->rssUrl = $rssUrl;
    }

    /**
     * @return Albums[]
     */
    public function getAlbums(): array
    {
        return $this->albums;
    }

    /**
     * @param Albums[] $albums
     */
    public function setAlbums(array $albums): void
    {
        $this->albums = $albums;
    }

    public function addAlbum(Album $album)
    {
        $this->albums->add($album);
    }

    public function jsonSerialize() : mixed
    {
        $serializer = SerializerBuilder::create()->build();
        return json_decode($serializer->serialize($this, 'json'));
    }


}