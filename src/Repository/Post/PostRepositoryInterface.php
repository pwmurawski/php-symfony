<?php

declare(strict_types=1);

namespace App\Repository\Post;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Uid\Uuid;

interface PostRepositoryInterface
{
    public function save(Post $entity): void;
    public function remove(Post $entity): void;
    public function getById(Uuid $id): ?Post;
    public function getByPostIdUserId(Uuid $postId, Uuid $userId): ?Post;
    public function getPostsByUserId(Uuid $id): array;
    public function getAll(): array;
}
