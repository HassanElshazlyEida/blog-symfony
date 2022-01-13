<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    // Functional used for controller and rendering

    /**
     * @dataProvider provideUrls
     */
    public function testSomething($url): void
    {

        $client = static::createClient();
        $client->catchExceptions(false);
        
        $crawler = $client->request('GET', $url);
        
        $this->assertSame(200,$client->getResponse()->getStatusCode());
       
        $this->assertStringContainsString('Hello', $crawler->filter('h1')->text());

        $this->assertGreaterThan(0,$crawler->filter('h1')->count());


        $link= $crawler
        ->filter('a:contains("go to login")')
        ->link();
        $crawler = $client->click($link);

        $this->assertStringContainsString('Remember me', $client->getResponse()->getContent());


        
    }

    public function provideUrls(){

        return [
            ['/default'],
            // ['/login']
        ];
    }
}
