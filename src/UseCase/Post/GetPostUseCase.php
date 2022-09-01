<?php

declare(strict_types=1);

namespace App\UseCase\Post;

use App\Entity\Post;
use Symfony\Component\Uid\Uuid;
use App\Repository\Post\PostRepositoryInterface;

class GetPostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(string $id): ?Post
    {
        return $this->postRepository->getById(new Uuid($id));
    }
}
