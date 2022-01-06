<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Video;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class VideoFixtures extends Fixture implements FixtureGroupInterface
{
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }
    // Seeders
    public function load(ObjectManager $manager): void
    {
       
        $sql = "Select * from user order by RAND() limit 1";
        $stmt=$this->em->getConnection()->prepare($sql);
        $user=$stmt->executeQuery()->fetchOne();
        $user=$this->em->getRepository(User::class)->find($user);
        for($i=0;$i<5;$i++){
            
            $video=new Video();
            $video->setTitle("Video title - ".$i);
            $user->addVideo($video);
            $manager->persist($video);
        }

        $manager->flush();
        dump("Video Has been created");
    }
    public static function getGroups(): array
    {
        return ['VideoFixtures'];
    }
}
