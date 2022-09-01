<?php

declare(strict_types=1);

namespace App\UseCase\User;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;
use App\Repository\User\UserRepositoryInterface;

class GetUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $id): ?User
    {
        return $this->userRepository->getById(new Uuid($id));
    }
}
