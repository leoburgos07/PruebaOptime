<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 4; $i++) 
        {
            $category = new Category();
            $category->setName('category '.$i);
            $category->setActive(true);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
