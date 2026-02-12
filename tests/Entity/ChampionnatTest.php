<?php

namespace App\Tests\Entity;

use App\Entity\Championnat;
use App\Entity\Competition;
use App\Entity\Sport;
use PHPUnit\Framework\TestCase;

class ChampionnatTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $championnat = new Championnat();

        $this->assertNull($championnat->getId());
        $this->assertNull($championnat->getNom());
        $this->assertNull($championnat->getSport());

        $championnat->setNom('Championnat de France');
        $this->assertSame('Championnat de France', $championnat->getNom());

        $sport = new Sport();
        $sport->setName('Football');
        $championnat->setSport($sport);
        $this->assertSame($sport, $championnat->getSport());
    }

    public function testCompetitionsCollection(): void
    {
        $championnat = new Championnat();
        $competition1 = new Competition();
        $competition1->setNom('Ligue 1');
        $competition2 = new Competition();
        $competition2->setNom('Coupe de France');

        $this->assertCount(0, $championnat->getCompetitions());

        $championnat->addCompetition($competition1);
        $this->assertCount(1, $championnat->getCompetitions());
        $this->assertTrue($championnat->getCompetitions()->contains($competition1));
        $this->assertSame($championnat, $competition1->getChampionnat());

        $championnat->addCompetition($competition2);
        $this->assertCount(2, $championnat->getCompetitions());

        // Test adding the same competition twice
        $championnat->addCompetition($competition1);
        $this->assertCount(2, $championnat->getCompetitions());

        $championnat->removeCompetition($competition1);
        $this->assertCount(1, $championnat->getCompetitions());
        $this->assertFalse($championnat->getCompetitions()->contains($competition1));
    }
}

