<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    // public function testGoodRegister(): void
    // {
    //     $crawler = $this->client->request('GET', '/register');
        
    //     $form = $crawler->selectButton('Sign-up')->form([
    //         'registration_form[email]' => 'mail2@gmail.com',
    //         'registration_form[plainPassword]' => 'azertyuiop',
    //         'registration_form[username]' => 'bonjour',
    //         'registration_form[agreeTerms]' => '1',
    //     ]);
        
    //     $this->client->submit($form);

    //     $this->assertResponseRedirects('/'); 
    //     $this->client->followRedirect();
    //     $this->assertResponseIsSuccessful();
    // }

    public function testWrongRegister(): void
    {
        $crawler = $this->client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        
        $form = $crawler->selectButton('Sign-up')->form([
            'registration_form[email]' => 'nomail.com',
            'registration_form[plainPassword]' => 'weak',
            'registration_form[username]' => 'hellocemoi',
            'registration_form[agreeTerms]' => '1',

        ]);
        
        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(422);

        fwrite(STDOUT, "The registration form submission failed with invalid data.\n");
    }
}