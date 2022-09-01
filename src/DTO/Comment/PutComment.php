<?php

declare(strict_types=1);

namespace App\DTO\Comment;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class PutComment
{
    private Uuid $id;

    private string $content;

    private User $user;

    private bool $isEdited = true;

    public function __construct(
        Uuid $id,
        User $user,
        string $content
    ) {
        $this->id = $id;
        $this->user = $user;
        $this->content = $content;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getIsEdited(): bool
    {
        return $this->isEdited;
    }
}
