<?php

namespace App\Entity;

use App\Repository\EpreuveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpreuveRepository::class)]
class Epreuve
{
    public const TYPE_INDIVIDUELLE = 'individuelle';
    public const TYPE_EQUIPE = 'equipe';
    public const TYPE_MIXTE = 'mixte';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: Competition::class, inversedBy: 'epreuves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Competition $competition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): static
    {
        $this->competition = $competition;

        return $this;
    }

    public static function getTypeChoices(): array
    {
        return [
            'Individuelle' => self::TYPE_INDIVIDUELLE,
            'Équipe' => self::TYPE_EQUIPE,
            'Mixte (Individuelle et Équipe)' => self::TYPE_MIXTE,
        ];
    }
}

