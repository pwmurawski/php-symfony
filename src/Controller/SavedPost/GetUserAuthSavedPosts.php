<?php

declare(strict_types=1);

namespace App\Controller\SavedPost;

use App\UseCase\SavedPost\GetSavedPostUseCase;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

class GetUserAuthSavedPosts extends AbstractFOSRestController
{
    private GetSavedPostUseCase $getSavedPostUseCase;

    public function __construct(GetSavedPostUseCase $getSavedPostUseCase)
    {
        $this->getSavedPostUseCase = $getSavedPostUseCase;
    }

    /**
     * @Route("/api/user/savedPosts", name="savedPost.get.user.savedPosts", methods={"GET"})
     */
    public function __invoke()
    {
        $savedPosts = $this->getSavedPostUseCase->execute($this->getUser()->getId());

        return $this->view($savedPosts, Response::HTTP_OK);
    }
}
