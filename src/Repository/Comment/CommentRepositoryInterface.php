<?php

declare(strict_types=1);

namespace App\Repository\Comment;

use App\Entity\Comment;
use Symfony\Component\Uid\Uuid;

interface CommentRepositoryInterface
{
    public function save(Comment $entity): void;
    public function remove(Comment $entity): void;
    public function getById(Uuid $id): ?Comment;
    public function getByCommentIdUserId(Uuid $commentId, Uuid $userId): ?Comment;
    public function getCommentsByPostId(Uuid $id): array;
}
