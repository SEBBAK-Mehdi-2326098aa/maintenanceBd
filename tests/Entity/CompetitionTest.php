<?php

namespace App\Tests\Entity;

use App\Entity\Championnat;
use App\Entity\Competition;
use App\Entity\Epreuve;
use PHPUnit\Framework\TestCase;

class CompetitionTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $competition = new Competition();

        $this->assertNull($competition->getId());
        $this->assertNull($competition->getNom());
        $this->assertNull($competition->getChampionnat());

        $competition->setNom('Ligue 1');
        $this->assertSame('Ligue 1', $competition->getNom());

        $championnat = new Championnat();
        $championnat->setNom('Championnat de France');
        $competition->setChampionnat($championnat);
        $this->assertSame($championnat, $competition->getChampionnat());
    }

    public function testEpreuvesCollection(): void
    {
        $competition = new Competition();
        $epreuve1 = new Epreuve();
        $epreuve1->setNom('100m');
        $epreuve2 = new Epreuve();
        $epreuve2->setNom('200m');

        $this->assertCount(0, $competition->getEpreuves());

        $competition->addEpreuve($epreuve1);
        $this->assertCount(1, $competition->getEpreuves());
        $this->assertTrue($competition->getEpreuves()->contains($epreuve1));
        $this->assertSame($competition, $epreuve1->getCompetition());

        $competition->addEpreuve($epreuve2);
        $this->assertCount(2, $competition->getEpreuves());

        // Test adding the same epreuve twice
        $competition->addEpreuve($epreuve1);
        $this->assertCount(2, $competition->getEpreuves());

        $competition->removeEpreuve($epreuve1);
        $this->assertCount(1, $competition->getEpreuves());
        $this->assertFalse($competition->getEpreuves()->contains($epreuve1));
    }
}

