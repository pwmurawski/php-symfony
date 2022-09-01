<?php

declare(strict_types=1);

namespace  App\UseCase\Comment;

use App\Entity\Comment;
use Symfony\Component\Uid\Uuid;
use App\Repository\Comment\CommentRepositoryInterface;

class GetCommentUseCase
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function execute(string $id): ?Comment
    {
        return $this->commentRepository->getById(new Uuid($id));
    }
}
