<?php

namespace App\DataFixtures;

use App\DataFixtures\Trait\DateTimeTrait;
use App\Entity\Category;
use App\Entity\Topic;
use App\Entity\User;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TopicFixtures extends Fixture implements DependentFixtureInterface
{
    use DateTimeTrait;    
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        static $index = 1;
        for ($a = 1; $a < 10; $a++) {
            for ($b = 1; $b < 5; $b++) {
                $randomIntUser = random_int(1, 12);
                /** @var User $randomUser */
                $randomUser = $this->getReference('user-' . $randomIntUser);
                /** @var Category $randomCategory */
                $randomCategory = $this->getReference('category-' . $a);

                $topic = new Topic();
                $topic
                    ->setTitle($this->faker->sentence(random_int(10, 20)))
                    ->setCategory($randomCategory)
                    ->setUser($randomUser)
                    ->setState(Topic::OPENED)
                    ->setCreatedAt($this->randomDate());
                $manager->persist($topic);
                $this->addReference('topic-' . $index++, $topic);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class
        ];
    }
}
