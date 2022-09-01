<?php

declare(strict_types=1);

namespace App\UseCase\Post;

use Symfony\Component\Uid\Uuid;
use App\Exception\Post\PostNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\Post\PostRepositoryInterface;

class DeletePostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(string $postId, Uuid $userId): void
    {
        $post = $this->postRepository->getByPostIdUserId(new Uuid($postId), $userId);

        if (!$post)
            throw new PostNotFoundException('Post dont found', Response::HTTP_NOT_FOUND);
        $this->postRepository->remove($post);
    }
}
