<?php

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginCredentialsTest extends WebTestCase
{

   
    public function testLoginUsingWebTest(): void
    {

        $client = static::createClient();
       
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Sign in')->form();

        $form['email'] ="test@app.com";
        $form['password'] = 'password';


        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertEquals(1, $crawler->filter('a:contains("Logout")')->count());
    }
 
}
