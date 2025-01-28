<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function __construct(public UserPasswordHasherInterface $password_hasher) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $departementsRepository = $manager->getRepository(Department::class);
        $departements = $departementsRepository->findAll();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);

            $password = $this->password_hasher->hashPassword($user, 'password123');
            $user->setPassword($password);

            $departementsCount = rand(1, 2);
            for ($j = 0; $j < $departementsCount; $j++) {
                $departement = $departements[array_rand($departements)];
                $user->addDepartment($departement);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
