<?php

namespace App\Tests;

use App\Entity\SecurityUser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IsolationRollbackTest extends WebTestCase
{
    private $em;

    protected function setUp() : void{

        parent::setUp();
        $this->client= static::createClient();
        $this->em= $this->client->getContainer()->get('doctrine.orm.entity_manager');

        $this->em->beginTransaction();
        $this->em->getConnection()->setAutoCommit(false);

    }

    public function testSomething(): void
    {
        $user= $this->em->getRepository(SecurityUser::class)->find(1);
       
        $this->em->remove($user);
        $this->em->flush();
        $this->assertNull($this->em->getRepository(SecurityUser::class)->find(1));
    }

    protected function tearDown(): void
    {
        // doing this is recommended to avoid database corruption
        $this->em->rollback();
        // doing this is recommended to avoid memory leaks
        $this->em->close();
        $this->em = null;
    }

}
