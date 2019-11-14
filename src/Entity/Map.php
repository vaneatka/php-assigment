<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MapRepository")
 */
class Map
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
     * @ORM\Column(type="json")
     */
    private $field = [];

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\FileContents", mappedBy="mapId")
     */

    private $map;

    public function __construct()
    {
        $this->map = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

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

    public function getField(): ?array
    {
        return $this->field;
    }

    public function setField(array $field): self
    {
        $this->field = $field;

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
            $map->setMapId($this);
        }

        return $this;
    }

    public function removeMap(FileContents $map): self
    {
        if ($this->map->contains($map)) {
            $this->map->removeElement($map);
            // set the owning side to null (unless already changed)
            if ($map->getMapId() === $this) {
                $map->setMapId(null);
            }
        }

        return $this;
    }
}
