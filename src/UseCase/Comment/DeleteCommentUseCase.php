<?php

declare(strict_types=1);

namespace App\UseCase\Comment;

use Symfony\Component\Uid\Uuid;
use App\Exception\Comment\CommentNotFoundException;
use App\Repository\Comment\CommentRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class DeleteCommentUseCase
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function execute(string $commentId, Uuid $userId)
    {
        $comment = $this->commentRepository->getByCommentIdUserId(new Uuid($commentId), $userId);

        if (!$comment)
            throw new CommentNotFoundException('Comment dont found', Response::HTTP_NOT_FOUND);
        $this->commentRepository->remove($comment);
    }
}
