<?php

namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepartmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $departements = [
            ['code' => '75', 'name' => 'Paris'],
            ['code' => '2A', 'name' => 'Corse-du-Sud'],
            ['code' => '2B', 'name' => 'Haute-Corse'],
            ['code' => '33', 'name' => 'Gironde'],
            ['code' => '13', 'name' => 'Bouches-du-Rhône'],
            ['code' => '44', 'name' => 'Loire-Atlantique'],
        ];

        foreach ($departements as $data) {
            $departement = new Department();
            $departement->setName($data['name']);
            $departement->setCode($data['code']);

            $manager->persist($departement);
        }

        $manager->flush();
    }
}
