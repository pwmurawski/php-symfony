<?php

declare(strict_types=1);

namespace App\Factory\Comment;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Comment;
use Symfony\Component\Uid\Uuid;

interface CommentFactoryInterface
{
    public function create(
        Uuid $id,
        string $content,
        User $user,
        Post $post,
        ?\DateTimeInterface $dateTime = null
    ): Comment;
}
