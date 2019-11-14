<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 */
class File
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
    private $fileId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $mapId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $documentType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="FileContents", mappedBy="fileId")
     */
    private $map;

    public function __construct()
    {
        $this->map = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
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

    public function getDocumentType(): ?string
    {
        return $this->documentType;
    }

    public function setDocumentType(string $documentType): self
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return Collection|FileContents[]
     */
    public function getMap(): Collection
    {
        return $this->map;
    }

    public function addMap(FileContents $map): self
    {
        if (!$this->map->contains($map)) {
            $this->map[] = $map;
            $map->setFileId($this);
        }

        return $this;
    }

    public function removeMap(FileContents $map): self
    {
        if ($this->map->contains($map)) {
            $this->map->removeElement($map);
            // set the owning side to null (unless already changed)
            if ($map->getFileId() === $this) {
                $map->setFileId(null);
            }
        }

        return $this;
    }
}
