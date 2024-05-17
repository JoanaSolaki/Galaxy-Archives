<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function testGoodLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        
        $form = $crawler->selectButton('Sign in')->form([
            '_username' => 'anonymous@anonymous.com',
            '_password' => '123456',
        ]);
        
        $this->client->submit($form);

        $this->assertResponseRedirects('/'); 
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testWrongLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        
        $this->assertResponseIsSuccessful();
    
        $form = $crawler->selectButton('Sign in')->form([
            '_username' => 'fakemail@gmail.com',
            '_password' => 'wrongpassword',
        ]);
        
        $this->client->submit($form);
    
        $this->assertResponseRedirects('/login');
    
        $crawler = $this->client->followRedirect();

        $this->assertSame('.alert-danger', 'Invalid credentials.');
    }
}