<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Post;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SavedPost\SavedPostRepository;

/**
 * @ORM\Entity(repositoryClass=SavedPostRepository::class)
 */
class SavedPost
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique="true")
     */
    private Uuid $id;

    /**
     * @ORM\Column(type="uuid")
     */
    private Uuid $userId;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private Post $post;

    public function __construct(Uuid $id, Uuid $userId, Post $post)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->post = $post;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUserId(): Uuid
    {
        return $this->userId;
    }

    public function getPost(): Post
    {
        return $this->post;
    }
}
