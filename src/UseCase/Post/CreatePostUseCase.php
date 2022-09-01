<?php

declare(strict_types=1);

namespace App\UseCase\Post;

use App\DTO\Post\CreatePost;
use App\Factory\Post\PostFactoryInterface;
use App\Repository\Post\PostRepositoryInterface;

class CreatePostUseCase
{
    private PostRepositoryInterface $postRepository;
    private PostFactoryInterface $postFactory;

    public function __construct(PostRepositoryInterface $postRepository, PostFactoryInterface $postFactory)
    {
        $this->postRepository = $postRepository;
        $this->postFactory = $postFactory;
    }

    public function execute(CreatePost $postData): void
    {
        $post = $this->postFactory->create(
            $postData->getId(),
            $postData->getTitle(),
            $postData->getContent(),
            $postData->getUser()
        );
        $this->postRepository->save($post);
    }
}
