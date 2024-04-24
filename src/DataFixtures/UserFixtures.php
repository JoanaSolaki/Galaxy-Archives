<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractFixtures;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractFixtures {
    public function load(ObjectManager $objectManager) {
        $adminUser = new User();
        $adminUser->setEmail('admin@gmail.com');
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setPassword($this->passwordHasher->hashPassword($adminUser, '123456'));
        $adminUser->setUsername('admin');

        $objectManager->persist($adminUser);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($this->faker->userName() . '@archives.com');
            $user->setPassword($this->passwordHasher->hashPassword($user, $this->faker->randomNumber(5, true)));
            $user->setRoles([]);
            $user->setUsername($this->faker->userName());

            $this->setReference('user_' . $i, $user);

            $objectManager->persist($user);
        }

        $objectManager->flush();
    }
}