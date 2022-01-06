<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    // Seeders
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // 
        for($i=0;$i<5;$i++){
            $user=new User();
            $user->setName('Name- '.$i);
            $user->setEmail("Email$i@gmail.com");
            $manager->persist($user);
        }
        $manager->flush();
    }
}
