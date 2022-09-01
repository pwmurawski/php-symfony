<?php

declare(strict_types=1);

namespace App\UseCase\Post;

use App\DTO\Post\PutPost;
use App\Exception\Post\PostNotFoundException;
use App\Repository\Post\PostRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class PutPostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(PutPost $putPostData)
    {
        $post = $this->postRepository->getByPostIdUserId($putPostData->getId(), $putPostData->getUser()->getId());

        if (!$post)
            throw new PostNotFoundException('Post dont found', Response::HTTP_NOT_FOUND);

        $post->setTitle($putPostData->getTitle());
        $post->setContent($putPostData->getContent());
        $post->setIsEdited($putPostData->getIsEdited());

        $this->postRepository->save($post);
    }
}
