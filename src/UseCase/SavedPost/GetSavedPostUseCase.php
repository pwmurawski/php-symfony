<?php

declare(strict_types=1);

namespace App\UseCase\SavedPost;

use App\Repository\SavedPost\SavedPostRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class GetSavedPostUseCase
{
    private SavedPostRepositoryInterface $savedPostRepository;

    public function __construct(SavedPostRepositoryInterface $savedPostRepository)
    {
        $this->savedPostRepository = $savedPostRepository;
    }

    public function execute(Uuid $userId): array
    {
        return $this->savedPostRepository->getSavedPostsByUserId($userId);
    }
}
