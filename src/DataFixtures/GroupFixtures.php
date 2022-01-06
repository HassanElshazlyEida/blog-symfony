<?php
namespace App\DataFixtures;
// ...
use App\DataFixtures\UserFixtures;
use App\DataFixtures\VideoFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GroupFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // ...
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            VideoFixtures::class,
        ];
    }
}