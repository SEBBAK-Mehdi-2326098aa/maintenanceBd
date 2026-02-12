<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SportRepository::class)]
class Sport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, Championnat>
     */
    #[ORM\OneToMany(targetEntity: Championnat::class, mappedBy: 'sport')]
    private Collection $championnats;

    public function __construct()
    {
        $this->championnats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Championnat>
     */
    public function getChampionnats(): Collection
    {
        return $this->championnats;
    }

    public function addChampionnat(Championnat $championnat): static
    {
        if (!$this->championnats->contains($championnat)) {
            $this->championnats->add($championnat);
            $championnat->setSport($this);
        }

        return $this;
    }

    public function removeChampionnat(Championnat $championnat): static
    {
        if ($this->championnats->removeElement($championnat)) {
            if ($championnat->getSport() === $this) {
                $championnat->setSport(null);
            }
        }

        return $this;
    }
}
