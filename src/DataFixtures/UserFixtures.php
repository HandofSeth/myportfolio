<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->setUsername('admin');
         $user->setRoles(['ROLE_ADMIN']);
         $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$Z0hnNngwaUJnUU1waHNMTQ$H8shzmNM+IUaUh65MwVUdU8rInCM1DXRZTYr+uwSXaY');
         $manager->persist($user);
         $manager->flush();
    }
}
