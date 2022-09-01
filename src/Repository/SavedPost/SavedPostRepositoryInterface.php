<?php

declare(strict_types=1);

namespace App\Repository\SavedPost;

use App\Entity\SavedPost;
use Symfony\Component\Uid\Uuid;

interface SavedPostRepositoryInterface
{
    public function save(SavedPost $entity): void;
    public function remove(SavedPost $entity): void;
    public function getSavedPostsByUserId(Uuid $userId): array;
    public function getSavedPostByPostId(Uuid $postId): array;
    public function getByPostIdUserId(Uuid $id, Uuid $userId): ?SavedPost;
}
