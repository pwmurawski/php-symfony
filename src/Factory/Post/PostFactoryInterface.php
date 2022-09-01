<?php

declare(strict_types=1);

namespace App\Factory\Post;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Uid\Uuid;

interface PostFactoryInterface
{
    public function create(
        Uuid $id,
        string $title,
        string $content,
        User $user,
        ?\DateTimeInterface $dateTime = null
    ): Post;
}
