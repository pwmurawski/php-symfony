<?php

declare(strict_types=1);

namespace App\UseCase\Post;

use App\Repository\Post\PostRepositoryInterface;

class GetAllPostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(): array
    {
        return $this->postRepository->getAll();
    }
}
