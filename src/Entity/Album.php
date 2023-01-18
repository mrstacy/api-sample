<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\SerializerBuilder;

/**
 * @ORM\Table(name="album", indexes={
 * })
 * @ORM\Entity()
 */
class Album implements \JsonSerializable
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

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected string $imageUrl;

    /*
     * @var float
     *
     * @ORM\Column(type="decimal", precision=7, scale=2, nullable=true)
     */
    protected float $price;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default"=false})
     */
    protected int $songCount;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected string $rights;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected \DateTime $releaseDate;


    protected Category $category;
    protected Artist $artist;

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
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getSongCount(): int
    {
        return $this->songCount;
    }

    /**
     * @param int $songCount
     */
    public function setSongCount(int $songCount): void
    {
        $this->songCount = $songCount;
    }

    /**
     * @return string
     */
    public function getRights(): string
    {
        return $this->rights;
    }

    /**
     * @param string $rights
     */
    public function setRights(string $rights): void
    {
        $this->rights = $rights;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate(): \DateTime
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTime $releaseDate
     */
    public function setReleaseDate(\DateTime $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Artist
     */
    public function getArtist(): Artist
    {
        return $this->artist;
    }

    /**
     * @param Artist $artist
     */
    public function setArtist(Artist $artist): void
    {
        $this->artist = $artist;
    }

    public function jsonSerialize() : mixed
    {
        $serializer = SerializerBuilder::create()->build();
        return json_decode($serializer->serialize($this, 'json'));
    }

}