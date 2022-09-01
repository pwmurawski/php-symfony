<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Comment\CommentRepository;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique="true")
     */
    private Uuid $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $dateTime;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private Post $post;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isEdited = false;

    public function __construct(
        Uuid $id,
        string $content,
        User $user,
        Post $post,
        ?\DateTimeInterface $dateTime = null
    ) {
        $this->id = $id;
        $this->content = $content;
        $this->user = $user;
        $this->post = $post;
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

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDateTime(): \DateTimeInterface
    {
        return $this->dateTime;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getIsEdited(): bool
    {
        return $this->isEdited;
    }

    public function setIsEdited(bool $isEdited): self
    {
        $this->isEdited = $isEdited;

        return $this;
    }
}
