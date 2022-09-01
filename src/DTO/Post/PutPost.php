<?php

declare(strict_types=1);

namespace App\DTO\Post;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class PutPost
{
    private Uuid $id;

    private User $user;

    private string $title;

    private string $content;

    private bool $isEdited = true;


    public function __construct(Uuid $id, User $user, string $title, string $content)
    {
        $this->id = $id;
        $this->user = $user;
        $this->title = $title;
        $this->content = $content;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
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
