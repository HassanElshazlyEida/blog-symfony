<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
  
    // Seeders
    public function load(ObjectManager $manager): void
    {
       
        // // User Seeder
        for($i=0;$i<5;$i++){

            $user=new User();
            $user->setName('Name- '.$i);
            $user->setEmail("Email".uniqid()."@gmail.com");
            $manager->persist($user);
        }
        $manager->flush();
        dump("User Has been created");

    }
    public static function getGroups(): array
    {
        return ['UserFixtures'];
    }
}
