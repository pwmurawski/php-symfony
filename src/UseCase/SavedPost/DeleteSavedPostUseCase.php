<?php

declare(strict_types=1);

namespace App\UseCase\SavedPost;

use Symfony\Component\Uid\Uuid;
use App\Exception\SavedPost\PostNotFoundException;
use App\Repository\SavedPost\SavedPostRepositoryInterface;

class DeleteSavedPostUseCase
{
    private SavedPostRepositoryInterface $savedPostRepository;

    public function __construct(
        SavedPostRepositoryInterface $savedPostRepository
    ) {
        $this->savedPostRepository = $savedPostRepository;
    }

    public function execute(Uuid $postId, Uuid $userId): void
    {
        $post = $this->savedPostRepository->getByPostIdUserId($postId, $userId);

        if (!$post) {
            throw new PostNotFoundException('Post dont found', 404);
        }

        $this->savedPostRepository->remove($post);
    }
}
