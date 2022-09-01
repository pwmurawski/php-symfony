<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\Factory\User\UserFactoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class UserLoadData extends Fixture
{
    private UserFactoryInterface $userFactory;
    private UserPasswordHasherInterface $hasher;

    public const USER_ID = '22200000-0000-474c-b092-b0dd880c07e2';
    public const USER_USERNAME = 'user@email.com';
    public const USER_PASSWORD = 'password';

    public function __construct(UserFactoryInterface $userFactory, UserPasswordHasherInterface $hasher)
    {
        $this->userFactory = $userFactory;
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userFactory->create(new Uuid(self::USER_ID), self::USER_USERNAME, self::USER_PASSWORD);
        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $user->getPassword(),
            )
        );

        $manager->persist($user);
        $manager->flush();
    }
}
