<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SportControllerTest extends WebTestCase
{
    public function testIndexPageReturnsSuccessfulResponse(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/sport/');

        $this->assertResponseIsSuccessful();
    }

    public function testIndexPageDisplaysTitle(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/sport/');

        $this->assertSelectorTextContains('h1', 'Liste des sports');
    }

    public function testIndexPageHasCreateLink(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/sport/');

        $this->assertSelectorExists('a[href="/sport/new"]');
    }

    public function testNewPageReturnsSuccessfulResponse(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/sport/new');

        $this->assertResponseIsSuccessful();
    }

    public function testNewPageDisplaysForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/sport/new');

        $this->assertSelectorExists('form');
        $this->assertSelectorExists('input[name="name"]');
    }
}

