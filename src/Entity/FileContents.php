<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileContentsRepository")
 */
class FileContents
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $mapId;

    /**
     * @ORM\Column(type="integer")
     */
    private $fileId;

    /**
     * @ORM\Column(type="json")
     */
    private $content = [];

    /**
     * @var File
     * @ORM\ManyToOne(targetEntity="File",inversedBy="mapId")
     * @ORM\JoinColumn(name="fileId", referencedColumnName="id")
     */
    private $file;

    /**
     * @var Map
     *@ORM\ManyToOne(targetEntity="Map", inversedBy="mapId")
     *@ORM\JoinColumn(name="mapId", referencedColumnName="id")
     */
    private $map;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMapId(): ?int
    {
        return $this->mapId;
    }

    public function setMapId(int $mapId): self
    {
        $this->mapId = $mapId;

        return $this;
    }

    public function getFileId(): ?int
    {
        return $this->fileId;
    }

    public function setFileId(int $fileId): self
    {
        $this->fileId = $fileId;

        return $this;
    }

    public function getContent(): ?array
    {
        return $this->content;
    }

    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getMap(): ?Map
    {
        return $this->map;
    }

    public function setMap(?Map $map): self
    {
        $this->map = $map;

        return $this;
    }
}
