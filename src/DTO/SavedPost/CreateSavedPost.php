<?php

declare(strict_types=1);

namespace App\DTO\SavedPost;

use Symfony\Component\Uid\Uuid;

class CreateSavedPost
{
    private Uuid $id;

    private Uuid $userId;

    private string $postId;

    public function __construct(Uuid $id, Uuid $userId, string $postId)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->postId = $postId;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUserId(): Uuid
    {
        return $this->userId;
    }

    public function getPostId(): string
    {
        return $this->postId;
    }
}
