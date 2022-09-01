<?php

declare(strict_types=1);

namespace App\UseCase\Comment;

use Symfony\Component\Uid\Uuid;
use App\Repository\Comment\CommentRepositoryInterface;

class GetPostCommentsUseCase
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function execute(string $id): array
    {
        return $this->commentRepository->getCommentsByPostId(new Uuid($id));
    }
}
