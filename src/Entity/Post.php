<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Post\PostRepository;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique="true")
     */
    private Uuid $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $dateTime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEdited = false;

    public function __construct(
        Uuid $id,
        string $title,
        string $content,
        User $user,
        ?\DateTimeInterface $dateTime = null
    ) {
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

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
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
