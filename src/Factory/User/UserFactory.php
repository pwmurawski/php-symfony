<?php

declare(strict_types=1);

namespace App\Factory\User;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class UserFactory implements UserFactoryInterface
{
    public function create(Uuid $id, string $email, string $password): User
    {
        return new User($id, $email, $password);
    }
}
