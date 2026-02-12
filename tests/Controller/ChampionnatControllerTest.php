<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChampionnatControllerTest extends WebTestCase
{
    public function testIndexPageReturnsSuccessfulResponse(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/championnat/');

        $this->assertResponseIsSuccessful();
    }

    public function testIndexPageDisplaysTitle(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/championnat/');

        $this->assertSelectorTextContains('h1', 'Liste des championnats');
    }

    public function testIndexPageHasCreateLink(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/championnat/');

        $this->assertSelectorExists('a[href="/championnat/new"]');
    }

    public function testNewPageReturnsSuccessfulResponse(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/championnat/new');

        $this->assertResponseIsSuccessful();
    }

    public function testNewPageDisplaysForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/championnat/new');

        $this->assertSelectorExists('form');
        $this->assertSelectorExists('input[name="nom"]');
        $this->assertSelectorExists('select[name="sport"]');
    }
}

