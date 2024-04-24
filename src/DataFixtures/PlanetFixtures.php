<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractFixtures;
use App\Entity\Planet;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlanetFixtures extends AbstractFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $objectManager) {

        $typePlanet = [
            "Exoplanet",
            "Gas planet",
            "Lava planet",
            "Ice planet",
            "Iron planet",
            "Helium planet",
            "Chthonian planet"
        ];

        $lifeCondition = [
            "Hostile",
            "Neutral",
            "Livable"
        ];

        $planetsImages = [
            "planet1.png",
            "planet2.png",
            "planet3.png",
            "planet4.png",
            "planet5.png",
            "planet6.png",
            "planet7.png",
            "planet8.png",
            "planet9.png",
            "planet10.png",
            "planet11.png",
            "planet12.png",
            "planet13.png"
        ];

        $galaxyReferences = [
            'galaxy_andromeda', 
            'galaxy_tadpole'
        ];

        for ($i = 0; $i < 10; $i++) {
            $planet = new Planet();
            $planet->setName($this->faker->word());
            $planet->setType($this->faker->randomElement($typePlanet));
            $planet->setLifeCondition($this->faker->randomElement($lifeCondition));
            $planet->setDescription($this->faker->text());
            $planet->setCreatedAt($this->faker->dateTimeBetween('-1 week', '+1 week'));
            $planet->setImageName($this->faker->randomElement($planetsImages));
            $planet->setAuthor($this->getReference('user_' . $this->faker->randomNumber(1, 9)));
            $randomGalaxyReference = $this->faker->randomElement($galaxyReferences);
            $planet->setGalaxy($this->getReference($randomGalaxyReference)); 

            $this->setReference('planet_' . $i, $planet);

            $objectManager->persist($planet);
        }

        $objectManager->flush();
    }

    function getDependencies()
    {
        return [
            UserFixtures::class,
            GalaxyFixtures::class,
        ];
    }
}