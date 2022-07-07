<?php

namespace App\DataFixtures;

use App\DataFixtures\Trait\DateTimeTrait;
use App\Entity\User;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    use DateTimeTrait;
    private Generator $faker;

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    )
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($a = 0; $a < 10; $a++) {
            $this->createUser($manager);
        }
        
        $users = $this->createCustomUsersArray();
        foreach ($users as $user) {
            $this->createUser($manager, $user);
        }

        $manager->flush();
    }

    private function createUser(ObjectManager $manager, array $data = []):void
    {
        static $index = 1;

        if(count($data) < 1){
            $firstname = $this->faker->firstName();
            $lastname = $this->faker->lastName();
            $data = [
                'username' => $lastname . '_' . $firstname,
                'roles' => ['ROLE_USER'],
                'password' => $this->faker->password(),
                'address' => null,
                'postalCode' => null,
                'city' => null,
                'email' => $this->faker->email(),
                'lastname' => $lastname,
                'firstname' => $firstname,
            ];
        }

        $user = new User();
        $user   
            ->setUsername($data['username'])
            ->setRoles($data['roles'])
            ->setPassword($this->passwordHasher->hashPassword($user, $data['password']))
            ->setAddress($data['address'])
            ->setPostalCode($data['postalCode'])
            ->setCity($data['city'])
            ->setEmail($data['email'])
            ->setLastname($data['lastname'])
            ->setFirstname($data['firstname'])
            ->setCreatedAt($this->randomDate());
        $manager->persist($user);
        $this->addReference('user-' . $index++, $user);
    }

    private function createCustomUsersArray():array
    {
        return [
            [
                'username' => 'bulb',
                'roles' => ['ROLE_USER'],
                'password' => 'bulb',
                'address' => 'HELLFEST',
                'postalCode' => '666',
                'city' => 'MetalLand',
                'email' => 'bulb@gmail.com',
                'lastname' => 'Mansoor',
                'firstname' => 'Misha'
            ],
            [
                'username' => 'mrak',
                'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
                'password' => 'mrak',
                'address' => 'HELLFEST',
                'postalCode' => '666',
                'city' => 'MetalLand',
                'email' => 'mrak@gmail.com',
                'lastname' => 'Holcomb',
                'firstname' => 'Mark'
            ]
        ];
    }
}
