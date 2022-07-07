<?php

namespace App\DataFixtures;

use App\DataFixtures\Trait\DateTimeTrait;
use App\Entity\Category;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    use DateTimeTrait;  
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($a = 1; $a < 10; $a++) {
            $category = new Category();
            $category
                ->setTitle($this->faker->sentence(5))
                ->setCreatedAt($this->randomDate());
            $manager->persist($category);
            $this->addReference('category-' . $a, $category);
        }

        $manager->flush();
    }
}
