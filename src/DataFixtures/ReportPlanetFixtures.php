<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractFixtures;
use App\Entity\ReportPlanet;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReportPlanetFixtures extends AbstractFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $objectManager) {

        for ($i = 0; $i < 10; $i++) {
            $reportPlanet = new ReportPlanet();
            $reportPlanet->setBody($this->faker->text(1000));
            $reportPlanet->setCreatedAt($this->faker->dateTimeBetween('-1 week', '+1 week'));
            $reportPlanet->setAuthor($this->getReference('user_' . $this->faker->randomNumber(1, 9)));
            $reportPlanet->setPlanet($this->getReference('planet_' . $this->faker->randomNumber(1, 9)));

            $objectManager->persist($reportPlanet);
        }

        $objectManager->flush();
    }

    function getDependencies()
    {
        return [
            UserFixtures::class,
            GalaxyFixtures::class,
            PlanetFixtures::class,
            LifeformFixtures::class,
        ];
    }
}