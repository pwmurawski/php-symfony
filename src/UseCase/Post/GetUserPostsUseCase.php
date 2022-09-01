<?php

declare(strict_types=1);

namespace App\UseCase\Post;

use Symfony\Component\Uid\Uuid;
use App\Repository\Post\PostRepositoryInterface;

class GetUserPostsUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(string $id): array
    {
        return $this->postRepository->getPostsByUserId(new Uuid($id));
    }
}
