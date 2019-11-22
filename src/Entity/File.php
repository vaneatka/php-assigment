<?php

namespace App\Entity;

use App\Entity\Map;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 */
class File
{
    /**
     * @var UuidInterface|null
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;

    /**
     * @param mixed $id
     * @return File
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $documentType;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $fileName;

    /**
     *  @ORM\Column(type="text", nullable=true)
     */
    private $rawText;

    /**
     * @return mixed
     */
    public function getRawText()
    {
        return $this->rawText;
    }

    /**
     * @param mixed $rawText
     */
    public function setRawText($rawText): self
    {
        $this->rawText = $rawText;

        return $this;
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var ArrayCollection
     *@ORM\OneToMany(targetEntity="Map", mappedBy="file")
     *
     */
    private $maps;

    public function __construct()
    {
        $this->maps = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Map[]
     */
    public function getMaps(): Collection
    {
        return $this->maps;
    }

    public function addMap(Map $map): self
    {
        if (!$this->maps->contains($map)) {
            $this->maps[] = $map;
            $map->setFile($this);
        }

        return $this;
    }

    public function removeMap(Map $map): self
    {
        if ($this->maps->contains($map)) {
            $this->maps->removeElement($map);
            // set the owning side to null (unless already changed)
            if ($map->getFile() === $this) {
                $map->setFile(null);
            }
        }

        return $this;
    }

}
