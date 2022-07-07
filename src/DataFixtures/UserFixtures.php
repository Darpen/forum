<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager, UserPasswordHasherInterface $passwordHasher): void
    {
        $createdAt = new DateTimeImmutable('now', new DateTimeZone('Europe/Paris'));
        // User
        $users = [
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
                'roles' => ['ROLE_ADMIN'],
                'password' => 'mrak',
                'address' => 'HELLFEST',
                'postalCode' => '666',
                'city' => 'MetalLand',
                'email' => 'mrak@gmail.com',
                'lastname' => 'Holcomb',
                'firstname' => 'Mark'
            ]
        ];
        foreach ($users as $userData) {
            $user = new User();
            $plaintextPassword = $userData['password'];
            $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
            $user   
                ->setUsername($userData['username'])
                ->setRoles($userData['roles'])
                ->setPassword($hashedPassword)
                ->setAddress($userData['address'])
                ->setPostalCode($userData['postalCode'])
                ->setCity($userData['city'])
                ->setEmail($userData['email'])
                ->setLastname($userData['lastname'])
                ->setFirstname($userData['firstname'])
                ->setCreatedAt($createdAt);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
