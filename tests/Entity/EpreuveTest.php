<?php

namespace App\Tests\Entity;

use App\Entity\Competition;
use App\Entity\Epreuve;
use PHPUnit\Framework\TestCase;

class EpreuveTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $epreuve = new Epreuve();

        $this->assertNull($epreuve->getId());
        $this->assertNull($epreuve->getNom());
        $this->assertNull($epreuve->getType());
        $this->assertNull($epreuve->getCompetition());

        $epreuve->setNom('100m');
        $this->assertSame('100m', $epreuve->getNom());

        $epreuve->setType(Epreuve::TYPE_INDIVIDUELLE);
        $this->assertSame(Epreuve::TYPE_INDIVIDUELLE, $epreuve->getType());

        $competition = new Competition();
        $competition->setNom('Championnats d\'Europe');
        $epreuve->setCompetition($competition);
        $this->assertSame($competition, $epreuve->getCompetition());
    }

    public function testTypeConstants(): void
    {
        $this->assertSame('individuelle', Epreuve::TYPE_INDIVIDUELLE);
        $this->assertSame('equipe', Epreuve::TYPE_EQUIPE);
        $this->assertSame('mixte', Epreuve::TYPE_MIXTE);
    }

    public function testGetTypeChoices(): void
    {
        $choices = Epreuve::getTypeChoices();

        $this->assertIsArray($choices);
        $this->assertCount(3, $choices);
        $this->assertArrayHasKey('Individuelle', $choices);
        $this->assertArrayHasKey('Équipe', $choices);
        $this->assertArrayHasKey('Mixte (Individuelle et Équipe)', $choices);
        $this->assertSame(Epreuve::TYPE_INDIVIDUELLE, $choices['Individuelle']);
        $this->assertSame(Epreuve::TYPE_EQUIPE, $choices['Équipe']);
        $this->assertSame(Epreuve::TYPE_MIXTE, $choices['Mixte (Individuelle et Équipe)']);
    }
}

