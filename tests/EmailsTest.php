<?php

namespace App\Tests;

use stdClass;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailsTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->enableProfiler();
        $crawler =$client->request('GET', '/default');
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertSame(1, $mailCollector->getMessageCount());

        $collectedMessages=$mailCollector->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Swift Message', $message);
        $this->assertSame('Hello Email', $message->getSubject());
        $this->assertSame('send@example.com', key($message->getFrom()));
        $this->assertSame('recipient@example.com', key($message->getTo()));
        $this->assertContains('You did it! You registered!',$message->getBody());

     
    }
}
