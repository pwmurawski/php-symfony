<?php

declare(strict_types=1);

namespace App\DTO\Post;

use DateTime;
use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class CreatePost
{
    private Uuid $id;

    private string $title;

    private string $content;

    private User $user;

    private \DateTimeInterface $dateTime;

    public function __construct(Uuid $id, string $title, string $content, User $user, ?\DateTimeInterface $dateTime = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->user = $user;
        $this->dateTime = $dateTime ?? new DateTime();
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

    public function getDateTime(): \DateTimeInterface
    {
        return $this->dateTime;
    }
}
