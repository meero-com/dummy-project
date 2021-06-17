<?php

declare(strict_types=1);

namespace App\Utils;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;

class DummyUserCreator
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(int $totalUser): bool
    {
        if ($totalUser < 0) {
            return false;
        }

        $faker = Factory::create();

        for ($i = 0; $i < $totalUser; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setFullName(sprintf('%s %s', $faker->firstName, $faker->lastName));
            $user->setPassword('myS3cr3tP4ss'.$i);
            $user->setUsername($faker->userName);

            $this->saveUser($user);
        }

        return true;
    }

    public function saveUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
