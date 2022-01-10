<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Pdf;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InheritanceEntitiesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // // Author Seeder
         for($i=0;$i<3;$i++){

            $author=new Author();
            $author->setName('Author Name - '.$i);
            $manager->persist($author);
            dump("Author Has been created");
            for($j=0;$j<3;$j++){
                $pdf=new Pdf();
                $pdf->setFileName('PDF name of author- '.$i);
                $pdf->setDescription("PDF desc of author = ".$i);
                $pdf->setSize(5454);
                $pdf->setOrientation('portrait');
                $pdf->setPagesNumber(100);
                $pdf->setAuthor($author);
                $manager->persist($pdf);
            }
            dump("PDF Has assigned to Author");
            for($j=0;$j<3;$j++){
                $video=new Video();
                $video->setFileName('Video name of author- '.$i);
                $video->setDescription("Video desc of author = ".$i);
                $video->setSize(5454);
                $video->setTitle('Video Title');
                $video->setFormat('mp4');
                $video->setDuration(123);
                $video->setAuthor($author);
                $manager->persist($video);
            }
            dump("Video Has assigned to Author");

        }
        $manager->flush();
    }
}
