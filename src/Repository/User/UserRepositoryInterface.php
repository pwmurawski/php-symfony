<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function remove(User $entity): void;
    public function getByEmail(string $value): ?User;
    public function getById(Uuid $id): ?User;
}
