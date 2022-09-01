<?php

declare(strict_types=1);

namespace App\UseCase\Comment;

use App\DTO\Comment\CreateComment;
use Symfony\Component\Uid\Uuid;
use App\Factory\Comment\CommentFactoryInterface;
use App\Repository\Post\PostRepositoryInterface;
use App\Repository\Comment\CommentRepositoryInterface;

class CreateCommentUseCase
{
    private CommentRepositoryInterface $commentRepository;
    private PostRepositoryInterface $postRepository;
    private CommentFactoryInterface $commentFactory;

    public function __construct(
        CommentRepositoryInterface $commentRepository,
        PostRepositoryInterface $postRepository,
        CommentFactoryInterface $commentFactory
    ) {
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
        $this->commentFactory = $commentFactory;
    }

    public function execute(CreateComment $commentData): void
    {
        $comment = $this->commentFactory->create(
            $commentData->getId(),
            $commentData->getContent(),
            $commentData->getUser(),
            $this->postRepository->getById(new Uuid($commentData->getPostId())),
        );
        $this->commentRepository->save($comment);
    }
}
