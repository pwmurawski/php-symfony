<?php

declare(strict_types=1);

namespace App\DTO\Comment;

use DateTime;
use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class CreateComment
{
    private Uuid $id;

    private string $content;

    private \DateTimeInterface $dateTime;

    private User $user;

    private string $postId;

    public function __construct(
        Uuid $id,
        string $content,
        User $user,
        string $postId,
        ?\DateTimeInterface $dateTime = null
    ) {
        $this->id = $id;
        $this->content = $content;
        $this->user = $user;
        $this->postId = $postId;
        $this->dateTime = $dateTime ?? new DateTime();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDateTime(): \DateTimeInterface
    {
        return $this->dateTime;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getPostId(): string
    {
        return $this->postId;
    }
}
