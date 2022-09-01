<?php

declare(strict_types=1);

namespace App\UseCase\SavedPost;

use App\DTO\SavedPost\CreateSavedPost;
use App\Factory\SavedPost\SavedPostFactoryInterface;
use App\Repository\Post\PostRepositoryInterface;
use App\Repository\SavedPost\SavedPostRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class AddSavedPostUseCase
{
    private SavedPostRepositoryInterface $savedPostRepository;
    private SavedPostFactoryInterface $savedPostFactory;
    private PostRepositoryInterface $postRepository;

    public function __construct(
        SavedPostRepositoryInterface $savedPostRepository,
        SavedPostFactoryInterface $savedPostFactory,
        PostRepositoryInterface $postRepository
    ) {
        $this->savedPostRepository = $savedPostRepository;
        $this->savedPostFactory = $savedPostFactory;
        $this->postRepository = $postRepository;
    }

    public function execute(CreateSavedPost $savedPostData): void
    {
        $savedPost = $this->savedPostFactory->create(
            $savedPostData->getId(),
            $savedPostData->getUserId(),
            $this->postRepository->getById(new Uuid($savedPostData->getPostId()))
        );

        $this->savedPostRepository->save($savedPost);
    }
}
