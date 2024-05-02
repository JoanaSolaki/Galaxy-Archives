<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractFixtures;
use App\Entity\ReportLifeform;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReportLifeformFixtures extends AbstractFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $objectManager) {

        for ($i = 0; $i < 10; $i++) {
            $reportLifeform = new ReportLifeform();
            $reportLifeform->setBody($this->faker->text(1000));
            $reportLifeform->setCreatedAt($this->faker->dateTimeBetween('-1 week', '+1 week'));
            $reportLifeform->setAuthor($this->getReference('user_' . $this->faker->randomNumber(1, 9)));
            $reportLifeform->setLifeform($this->getReference('lifeform_' . $this->faker->randomNumber(1, 9)));

            $objectManager->persist($reportLifeform);
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
            ReportPlanetFixtures::class,
        ];
    }
}