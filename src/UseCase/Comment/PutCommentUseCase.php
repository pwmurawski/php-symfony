<?php

declare(strict_types=1);

namespace App\UseCase\Comment;

use App\DTO\Comment\PutComment;
use App\Exception\Comment\CommentNotFoundException;
use App\Repository\Comment\CommentRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class PutCommentUseCase
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function execute(PutComment $putCommentData)
    {
        $comment = $this->commentRepository->getByCommentIdUserId($putCommentData->getId(), $putCommentData->getUser()->getId());

        if (!$comment)
            throw new CommentNotFoundException('Comment dont found', Response::HTTP_NOT_FOUND);

        $comment->setContent($putCommentData->getContent());
        $comment->setIsEdited($putCommentData->getIsEdited());

        $this->commentRepository->save($comment);
    }
}
