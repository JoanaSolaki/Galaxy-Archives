<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractFixtures;
use App\Entity\Galaxy;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GalaxyFixtures extends AbstractFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $objectManager) {

        $galaxyReferences = [];

        $galaxyAndromeda = new Galaxy();
        $galaxyAndromeda->setName('Andromeda');
        $galaxyAndromeda->setParticularities($this->faker->text());
        $galaxyAndromeda->setDescription($this->faker->text());
        $galaxyAndromeda->setCreatedAt($this->faker->dateTimeBetween('-1 week', '+1 week'));
        $galaxyAndromeda->setImageName('galaxyAndromeda.jpg');
        $galaxyAndromeda->setAuthor($this->getReference('user_' . $this->faker->randomNumber(1, 9)));

        $objectManager->persist($galaxyAndromeda);

        $galaxyTadpole = new Galaxy();
        $galaxyTadpole->setName('Tadpole Galaxy');
        $galaxyTadpole->setParticularities($this->faker->text());
        $galaxyTadpole->setDescription($this->faker->text());
        $galaxyTadpole->setCreatedAt($this->faker->dateTimeBetween('-1 week', '+1 week'));
        $galaxyTadpole->setImageName('galaxyTadpole.jpg');
        $galaxyTadpole->setAuthor($this->getReference('user_' . $this->faker->randomNumber(1, 9)));

        $objectManager->persist($galaxyTadpole);

        $this->setReference('galaxy_andromeda', $galaxyAndromeda);
        $this->setReference('galaxy_tadpole', $galaxyTadpole);
        
        $objectManager->flush();
    }

    function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}