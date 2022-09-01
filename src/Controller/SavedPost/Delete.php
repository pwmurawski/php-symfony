<?php

declare(strict_types=1);

namespace App\Controller\SavedPost;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\UseCase\SavedPost\DeleteSavedPostUseCase;
use App\Exception\SavedPost\PostNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class Delete extends AbstractFOSRestController
{
    private DeleteSavedPostUseCase $deleteSavedPostUseCase;

    public function __construct(DeleteSavedPostUseCase $deleteSavedPostUseCase)
    {
        $this->deleteSavedPostUseCase = $deleteSavedPostUseCase;
    }

    /**
     * @Route("/api/savedPost/post/{id}", name="savedPost.delete", methods={"DELETE"})
     */
    public function __invoke(string $id)
    {
        try {
            $this->deleteSavedPostUseCase->execute(new Uuid($id), $this->getUser()->getId());

            return $this->view(null, Response::HTTP_NO_CONTENT);
        } catch (PostNotFoundException $e) {
            return $this->view($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
