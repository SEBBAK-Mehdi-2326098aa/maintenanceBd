<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomePageReturnsSuccessfulResponse(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $this->assertResponseIsSuccessful();
    }

    public function testHomePageDisplaysHello(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $this->assertSelectorTextContains('h1', 'Hello');
    }
}
