<?php

namespace App\Tests\Controller;

use App\Entity\Championnat;
use App\Entity\Competition;
use App\Entity\Sport;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EpreuveControllerTest extends WebTestCase
{
    public function testIndexPageReturnsSuccessfulResponse(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        // Create test data
        $sport = new Sport();
        $sport->setName('Test Sport Epreuve 1');
        $entityManager->persist($sport);

        $championnat = new Championnat();
        $championnat->setNom('Test Championnat Epreuve 1');
        $championnat->setSport($sport);
        $entityManager->persist($championnat);

        $competition = new Competition();
        $competition->setNom('Test Competition Epreuve 1');
        $competition->setChampionnat($championnat);
        $entityManager->persist($competition);
        $entityManager->flush();

        $crawler = $client->request('GET', '/epreuve/competition/' . $competition->getId());

        $this->assertResponseIsSuccessful();

        // Clean up
        $entityManager->remove($competition);
        $entityManager->remove($championnat);
        $entityManager->remove($sport);
        $entityManager->flush();
    }

    public function testIndexPageDisplaysTitle(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $sport = new Sport();
        $sport->setName('Test Sport Epreuve 2');
        $entityManager->persist($sport);

        $championnat = new Championnat();
        $championnat->setNom('Test Championnat Epreuve 2');
        $championnat->setSport($sport);
        $entityManager->persist($championnat);

        $competition = new Competition();
        $competition->setNom('Test Competition Epreuve 2');
        $competition->setChampionnat($championnat);
        $entityManager->persist($competition);
        $entityManager->flush();

        $crawler = $client->request('GET', '/epreuve/competition/' . $competition->getId());

        $this->assertSelectorTextContains('h1', 'Épreuves de la compétition');

        // Clean up
        $entityManager->remove($competition);
        $entityManager->remove($championnat);
        $entityManager->remove($sport);
        $entityManager->flush();
    }

    public function testIndexPageHasCreateLink(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $sport = new Sport();
        $sport->setName('Test Sport Epreuve 3');
        $entityManager->persist($sport);

        $championnat = new Championnat();
        $championnat->setNom('Test Championnat Epreuve 3');
        $championnat->setSport($sport);
        $entityManager->persist($championnat);

        $competition = new Competition();
        $competition->setNom('Test Competition Epreuve 3');
        $competition->setChampionnat($championnat);
        $entityManager->persist($competition);
        $entityManager->flush();

        $crawler = $client->request('GET', '/epreuve/competition/' . $competition->getId());

        $this->assertSelectorExists('a[href="/epreuve/new/' . $competition->getId() . '"]');

        // Clean up
        $entityManager->remove($competition);
        $entityManager->remove($championnat);
        $entityManager->remove($sport);
        $entityManager->flush();
    }

    public function testNewPageReturnsSuccessfulResponse(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $sport = new Sport();
        $sport->setName('Test Sport Epreuve 4');
        $entityManager->persist($sport);

        $championnat = new Championnat();
        $championnat->setNom('Test Championnat Epreuve 4');
        $championnat->setSport($sport);
        $entityManager->persist($championnat);

        $competition = new Competition();
        $competition->setNom('Test Competition Epreuve 4');
        $competition->setChampionnat($championnat);
        $entityManager->persist($competition);
        $entityManager->flush();

        $crawler = $client->request('GET', '/epreuve/new/' . $competition->getId());

        $this->assertResponseIsSuccessful();

        // Clean up
        $entityManager->remove($competition);
        $entityManager->remove($championnat);
        $entityManager->remove($sport);
        $entityManager->flush();
    }

    public function testNewPageDisplaysForm(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $sport = new Sport();
        $sport->setName('Test Sport Epreuve 5');
        $entityManager->persist($sport);

        $championnat = new Championnat();
        $championnat->setNom('Test Championnat Epreuve 5');
        $championnat->setSport($sport);
        $entityManager->persist($championnat);

        $competition = new Competition();
        $competition->setNom('Test Competition Epreuve 5');
        $competition->setChampionnat($championnat);
        $entityManager->persist($competition);
        $entityManager->flush();

        $crawler = $client->request('GET', '/epreuve/new/' . $competition->getId());

        $this->assertSelectorExists('form');
        $this->assertSelectorExists('input[name="nom"]');
        $this->assertSelectorExists('select[name="type"]');

        // Clean up
        $entityManager->remove($competition);
        $entityManager->remove($championnat);
        $entityManager->remove($sport);
        $entityManager->flush();
    }

    public function testIndexPageReturns404ForInvalidCompetition(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/epreuve/competition/99999');

        $this->assertResponseStatusCodeSame(404);
    }
}

