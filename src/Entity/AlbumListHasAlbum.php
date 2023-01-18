<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class AlbumListHasAlbum
{

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", nullable=false)
     */
    protected int $id;


    protected Album $album;
    protected AlbumList $albumList;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false default=0)
     */
    protected int $rank;


}