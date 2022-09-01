<?php

declare(strict_types=1);

namespace App\Factory\User;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

interface UserFactoryInterface
{
    public function create(Uuid $id, string $email, string $password): User;
}
