<?php

declare(strict_types=1);

namespace App\UseCase\User;

use App\DTO\User\CreateUser;
use App\Factory\User\UserFactoryInterface;
use App\Repository\User\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserUseCase
{
    private UserFactoryInterface $userFactory;
    private UserRepositoryInterface $userRepository;
    private UserPasswordHasherInterface $hasher;

    public function __construct(
        UserFactoryInterface $userFactory,
        UserRepositoryInterface $userRepository,
        UserPasswordHasherInterface $hasher
    ) {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    public function execute(CreateUser $userData): void
    {
        $user = $this->userFactory->create($userData->getId(), $userData->getEmail(), $userData->getPassword());
        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $user->getPassword(),
            )
        );

        $this->userRepository->save($user);
    }
}
