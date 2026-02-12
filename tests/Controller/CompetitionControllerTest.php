<?php

namespace App\Tests\Controller;

use App\Entity\Championnat;
use App\Entity\Sport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompetitionControllerTest extends WebTestCase
{
    public function testIndexPageReturnsSuccessfulResponse(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        // Create test data
        $sport = new Sport();
        $sport->setName('Test Sport');
        $entityManager->persist($sport);

        $championnat = new Championnat();
        $championnat->setNom('Test Championnat');
        $championnat->setSport($sport);
        $entityManager->persist($championnat);
        $entityManager->flush();

        $crawler = $client->request('GET', '/competition/championnat/' . $championnat->getId());

        $this->assertResponseIsSuccessful();

        // Clean up
        $entityManager->remove($championnat);
        $entityManager->remove($sport);
        $entityManager->flush();
    }

    public function testIndexPageDisplaysTitle(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $sport = new Sport();
        $sport->setName('Test Sport 2');
        $entityManager->persist($sport);

        $championnat = new Championnat();
        $championnat->setNom('Test Championnat 2');
        $championnat->setSport($sport);
        $entityManager->persist($championnat);
        $entityManager->flush();

        $crawler = $client->request('GET', '/competition/championnat/' . $championnat->getId());

        $this->assertSelectorTextContains('h1', 'Compétitions du championnat');

        // Clean up
        $entityManager->remove($championnat);
        $entityManager->remove($sport);
        $entityManager->flush();
    }

    public function testIndexPageHasCreateLink(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $sport = new Sport();
        $sport->setName('Test Sport 3');
        $entityManager->persist($sport);

        $championnat = new Championnat();
        $championnat->setNom('Test Championnat 3');
        $championnat->setSport($sport);
        $entityManager->persist($championnat);
        $entityManager->flush();

        $crawler = $client->request('GET', '/competition/championnat/' . $championnat->getId());

        $this->assertSelectorExists('a[href="/competition/new/' . $championnat->getId() . '"]');

        // Clean up
        $entityManager->remove($championnat);
        $entityManager->remove($sport);
        $entityManager->flush();
    }

    public function testNewPageReturnsSuccessfulResponse(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $sport = new Sport();
        $sport->setName('Test Sport 4');
        $entityManager->persist($sport);

        $championnat = new Championnat();
        $championnat->setNom('Test Championnat 4');
        $championnat->setSport($sport);
        $entityManager->persist($championnat);
        $entityManager->flush();

        $crawler = $client->request('GET', '/competition/new/' . $championnat->getId());

        $this->assertResponseIsSuccessful();

        // Clean up
        $entityManager->remove($championnat);
        $entityManager->remove($sport);
        $entityManager->flush();
    }

    public function testNewPageDisplaysForm(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $sport = new Sport();
        $sport->setName('Test Sport 5');
        $entityManager->persist($sport);

        $championnat = new Championnat();
        $championnat->setNom('Test Championnat 5');
        $championnat->setSport($sport);
        $entityManager->persist($championnat);
        $entityManager->flush();

        $crawler = $client->request('GET', '/competition/new/' . $championnat->getId());

        $this->assertSelectorExists('form');
        $this->assertSelectorExists('input[name="nom"]');

        // Clean up
        $entityManager->remove($championnat);
        $entityManager->remove($sport);
        $entityManager->flush();
    }

    public function testIndexPageReturns404ForInvalidChampionnat(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/competition/championnat/99999');

        $this->assertResponseStatusCodeSame(404);
    }
}

