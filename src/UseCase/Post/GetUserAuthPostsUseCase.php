<?php

declare(strict_types=1);

namespace App\UseCase\Post;

use App\Repository\Post\PostRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class GetUserAuthPostsUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(Uuid $userId): array
    {
        return $this->postRepository->getPostsByUserId($userId);
    }
}
