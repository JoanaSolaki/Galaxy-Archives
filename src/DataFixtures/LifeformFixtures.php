<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractFixtures;
use App\Entity\Lifeform;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LifeformFixtures extends AbstractFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $objectManager) {

        $species = [
            "Aquatic",
            "Terrestrial",
            "Aerial"
        ];

        $behavior = [
            "Hostile",
            "Neutral",
            "Friendly"
        ];

        $creaturesImages = [
            "creature1.jpg",
            "creature2.jpg",
            "creature3.jpg",
            "creature4.jpg",
            "creature5.jpg",
            "creature6.jpg",
            "creature7.jpg",
            "creature8.jpg",
            "creature9.jpg",
            "creature10.jpg",
            "creature11.jpg"
        ];

        for ($i = 0; $i < 10; $i++) {
            $lifeform = new Lifeform();
            $lifeform->setName($this->faker->word());
            $lifeform->setSpecies($this->faker->randomElement($species));
            $lifeform->setBehavior($this->faker->randomElement($behavior));
            $lifeform->setDescription($this->faker->text());
            $lifeform->setCreatedAt($this->faker->dateTimeBetween('-1 week', '+1 week'));
            $lifeform->setImageName($this->faker->randomElement($creaturesImages));
            $lifeform->setAuthor($this->getReference('user_' . $this->faker->randomNumber(1, 9)));
            $lifeform->addPlanet($this->getReference('planet_' . $this->faker->randomNumber(1, 9)));

            $objectManager->persist($lifeform);
        }

        $objectManager->flush();
    }

    function getDependencies()
    {
        return [
            UserFixtures::class,
            PlanetFixtures::class,
        ];
    }
}