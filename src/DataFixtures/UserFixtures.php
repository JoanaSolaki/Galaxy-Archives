<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractFixtures;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractFixtures {
    public function load(ObjectManager $objectManager) {
        $adminUser = new User();
        $adminUser->setEmail('admin@admin.com');
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setPassword($this->passwordHasher->hashPassword($adminUser, '123456'));
        $adminUser->setUsername('admin');

        $objectManager->persist($adminUser);

        $anonymousUser = new User();
        $anonymousUser->setEmail('anonymous@anonymous.com');
        $anonymousUser->setRoles(['ROLE_ANONYMOUS']);
        $anonymousUser->setPassword($this->passwordHasher->hashPassword($anonymousUser, '123456'));
        $anonymousUser->setUsername('anonymous');

        $objectManager->persist($anonymousUser);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $userUsername = $this->faker->userName();
            $user->setEmail($userUsername . '@archives.com');
            $user->setPassword($this->passwordHasher->hashPassword($user, $this->faker->randomNumber(5, true)));
            $user->setRoles([]);
            $user->setUsername($userUsername);

            $this->setReference('user_' . $i, $user);

            $objectManager->persist($user);
        }

        $objectManager->flush();
    }
}