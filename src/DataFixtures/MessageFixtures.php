<?php

namespace App\DataFixtures;

use App\DataFixtures\Trait\DateTimeTrait;
use App\Entity\Message;
use App\Entity\Topic;
use App\Entity\User;
use App\Entity\UserVote;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    use DateTimeTrait;
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($a = 1; $a < 37; $a++) {
            for ($b = 1; $b < 5; $b++) {
                $randomIntUser = random_int(1, 12);
                /** @var User $randomUser */
                $randomUser = $this->getReference('user-' . $randomIntUser);
                /** @var Topic $randomTopic */
                $randomTopic = $this->getReference('topic-' . $a);

                $message = new Message();
                $message
                    ->setContent($this->faker->realText())
                    ->setTopic($randomTopic)
                    ->setUser($randomUser)
                    ->setActive(true)
                    ->setCreatedAt($this->randomDate());
                $manager->persist($message);

                // Pour chaque message l'utilisateur à une chance de voter soit up ou down
                if(random_int(0,1) === 1){
                    $this->createUserVote($manager, $randomUser, $message);
                }
            }
        }
        $manager->flush();
    }

    private function createUserVote(ObjectManager $manager, User $user, Message $message):void
    {
        $action = random_int(0,1) === 1 ? UserVote::UP : UserVote::DOWN;
        $userVote = new UserVote();
        $userVote
            ->setUser($user)
            ->setMessage($message)
            ->setAction($action);
        $manager->persist($userVote);
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
            TopicFixtures::class
        ];
    }
}
