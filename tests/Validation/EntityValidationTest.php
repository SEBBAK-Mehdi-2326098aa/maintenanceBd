<?php

namespace App\Tests\Validation;

use App\Entity\Championnat;
use App\Entity\Competition;
use App\Entity\Epreuve;
use App\Entity\Sport;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Tests de validation des entités
 */
class EntityValidationTest extends KernelTestCase
{
    private ?ValidatorInterface $validator = null;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = static::getContainer()->get('validator');
    }

    /**
     * Test : Sport avec nom valide
     */
    public function testValidSport(): void
    {
        $sport = new Sport();
        $sport->setName('Football');

        $errors = $this->validator->validate($sport);
        $this->assertCount(0, $errors);
    }

    /**
     * Test : Championnat avec données valides
     */
    public function testValidChampionnat(): void
    {
        $sport = new Sport();
        $sport->setName('Basketball');

        $championnat = new Championnat();
        $championnat->setNom('NBA 2024');
        $championnat->setSport($sport);

        $errors = $this->validator->validate($championnat);
        $this->assertCount(0, $errors);
    }

    /**
     * Test : Competition avec données valides
     */
    public function testValidCompetition(): void
    {
        $sport = new Sport();
        $sport->setName('Tennis');

        $championnat = new Championnat();
        $championnat->setNom('ATP Tour');
        $championnat->setSport($sport);

        $competition = new Competition();
        $competition->setNom('Roland Garros');
        $competition->setChampionnat($championnat);

        $errors = $this->validator->validate($competition);
        $this->assertCount(0, $errors);
    }

    /**
     * Test : Epreuve avec données valides
     */
    public function testValidEpreuve(): void
    {
        $sport = new Sport();
        $sport->setName('Athlétisme');

        $championnat = new Championnat();
        $championnat->setNom('Championnats du Monde');
        $championnat->setSport($sport);

        $competition = new Competition();
        $competition->setNom('Finales');
        $competition->setChampionnat($championnat);

        $epreuve = new Epreuve();
        $epreuve->setNom('100m');
        $epreuve->setType(Epreuve::TYPE_INDIVIDUELLE);
        $epreuve->setCompetition($competition);

        $errors = $this->validator->validate($epreuve);
        $this->assertCount(0, $errors);
    }

    /**
     * Test : Les constantes de type d'épreuve sont correctes
     */
    public function testEpreuveTypeConstants(): void
    {
        $this->assertEquals('individuelle', Epreuve::TYPE_INDIVIDUELLE);
        $this->assertEquals('equipe', Epreuve::TYPE_EQUIPE);
        $this->assertEquals('mixte', Epreuve::TYPE_MIXTE);

        $choices = Epreuve::getTypeChoices();
        $this->assertIsArray($choices);
        $this->assertCount(3, $choices);
        $this->assertArrayHasKey('Individuelle', $choices);
        $this->assertArrayHasKey('Équipe', $choices);
        $this->assertArrayHasKey('Mixte (Individuelle et Équipe)', $choices);
    }

    /**
     * Test : Vérifier que les relations sont bien configurées
     */
    public function testEntityRelationsAreProperlyConfigured(): void
    {
        $sport = new Sport();
        $sport->setName('Volleyball');

        // Vérifier que la collection des championnats est initialisée
        $this->assertInstanceOf(\Doctrine\Common\Collections\Collection::class, $sport->getChampionnats());
        $this->assertCount(0, $sport->getChampionnats());

        $championnat = new Championnat();
        $championnat->setNom('Champions League');
        $championnat->setSport($sport);

        // Vérifier que la collection des compétitions est initialisée
        $this->assertInstanceOf(\Doctrine\Common\Collections\Collection::class, $championnat->getCompetitions());
        $this->assertCount(0, $championnat->getCompetitions());

        $competition = new Competition();
        $competition->setNom('Phase de Groupes');
        $competition->setChampionnat($championnat);

        // Vérifier que la collection des épreuves est initialisée
        $this->assertInstanceOf(\Doctrine\Common\Collections\Collection::class, $competition->getEpreuves());
        $this->assertCount(0, $competition->getEpreuves());
    }

    /**
     * Test : Ajout et suppression dans les collections
     */
    public function testCollectionManipulation(): void
    {
        $sport = new Sport();
        $sport->setName('Rugby');

        $championnat1 = new Championnat();
        $championnat1->setNom('Top 14');
        $championnat1->setSport($sport);

        $championnat2 = new Championnat();
        $championnat2->setNom('Pro D2');
        $championnat2->setSport($sport);

        // Tester addChampionnat
        $sport->addChampionnat($championnat1);
        $this->assertCount(1, $sport->getChampionnats());
        $this->assertTrue($sport->getChampionnats()->contains($championnat1));

        $sport->addChampionnat($championnat2);
        $this->assertCount(2, $sport->getChampionnats());

        // Tester removeChampionnat
        $sport->removeChampionnat($championnat1);
        $this->assertCount(1, $sport->getChampionnats());
        $this->assertFalse($sport->getChampionnats()->contains($championnat1));
        $this->assertTrue($sport->getChampionnats()->contains($championnat2));
    }

    /**
     * Test : Les méthodes getter/setter fonctionnent correctement
     */
    public function testGettersAndSetters(): void
    {
        $sport = new Sport();
        $sport->setName('Natation');
        $this->assertEquals('Natation', $sport->getName());

        $championnat = new Championnat();
        $championnat->setNom('Championnats Européens');
        $championnat->setSport($sport);
        $this->assertEquals('Championnats Européens', $championnat->getNom());
        $this->assertSame($sport, $championnat->getSport());

        $competition = new Competition();
        $competition->setNom('50m Nage Libre');
        $competition->setChampionnat($championnat);
        $this->assertEquals('50m Nage Libre', $competition->getNom());
        $this->assertSame($championnat, $competition->getChampionnat());

        $epreuve = new Epreuve();
        $epreuve->setNom('Finale Hommes');
        $epreuve->setType(Epreuve::TYPE_INDIVIDUELLE);
        $epreuve->setCompetition($competition);
        $this->assertEquals('Finale Hommes', $epreuve->getNom());
        $this->assertEquals(Epreuve::TYPE_INDIVIDUELLE, $epreuve->getType());
        $this->assertSame($competition, $epreuve->getCompetition());
    }

    /**
     * Test : Vérifier que les ID sont null avant persistence
     */
    public function testIdIsNullBeforePersistence(): void
    {
        $sport = new Sport();
        $sport->setName('Cyclisme');
        $this->assertNull($sport->getId());

        $championnat = new Championnat();
        $championnat->setNom('Tour de France');
        $this->assertNull($championnat->getId());

        $competition = new Competition();
        $competition->setNom('Étape 1');
        $this->assertNull($competition->getId());

        $epreuve = new Epreuve();
        $epreuve->setNom('Sprint Intermédiaire');
        $this->assertNull($epreuve->getId());
    }

    /**
     * Test : Les types d'épreuves sont valides
     */
    public function testAllEpreuveTypesAreValid(): void
    {
        $sport = new Sport();
        $sport->setName('Sport Multi-Type');

        $championnat = new Championnat();
        $championnat->setNom('Championnat Multi-Type');
        $championnat->setSport($sport);

        $competition = new Competition();
        $competition->setNom('Compétition Multi-Type');
        $competition->setChampionnat($championnat);

        // Test TYPE_INDIVIDUELLE
        $epreuve1 = new Epreuve();
        $epreuve1->setNom('Épreuve Individuelle');
        $epreuve1->setType(Epreuve::TYPE_INDIVIDUELLE);
        $epreuve1->setCompetition($competition);
        $errors1 = $this->validator->validate($epreuve1);
        $this->assertCount(0, $errors1);

        // Test TYPE_EQUIPE
        $epreuve2 = new Epreuve();
        $epreuve2->setNom('Épreuve Équipe');
        $epreuve2->setType(Epreuve::TYPE_EQUIPE);
        $epreuve2->setCompetition($competition);
        $errors2 = $this->validator->validate($epreuve2);
        $this->assertCount(0, $errors2);

        // Test TYPE_MIXTE
        $epreuve3 = new Epreuve();
        $epreuve3->setNom('Épreuve Mixte');
        $epreuve3->setType(Epreuve::TYPE_MIXTE);
        $epreuve3->setCompetition($competition);
        $errors3 = $this->validator->validate($epreuve3);
        $this->assertCount(0, $errors3);
    }
}

