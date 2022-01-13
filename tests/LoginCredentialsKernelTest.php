<?php

namespace App\Tests;

use App\Entity\SecurityUser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LoginCredentialsKernelTest extends KernelTestCase
{
    private $em;
    private $encoder;
    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get('Doctrine\ORM\EntityManagerInterface');
        $this->encoder = self::getContainer()->get('Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface');
       
    }
    public function testLoginUsingKernelTest(): void
    {
        $email="superadministrator@app.com";
        $password = 'password';
        $user     = $this->em->getRepository(SecurityUser::class)->findOneByEmail($email);
        
        if ($user === null) {
           $this->assertTrue(false);
        }
        if ($this->encoder->isPasswordValid($user, $password)) {
            $this->assertTrue(true);
        }else {
            $this->assertTrue(false);
        }
    }
}
