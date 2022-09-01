<?php

declare(strict_types=1);

namespace App\Controller\Post;

use App\UseCase\Post\DeletePostUseCase;
use App\Exception\Post\PostNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class Delete extends AbstractFOSRestController
{
    private DeletePostUseCase $deletePostUseCase;

    public function __construct(DeletePostUseCase $deletePostUseCase)
    {
        $this->deletePostUseCase = $deletePostUseCase;
    }

    /**
     * @Route("/api/post/{postId}", name="post.delete", methods={"DELETE"})
     */
    public function __invoke(string $postId)
    {
        try {
            $this->deletePostUseCase->execute($postId, $this->getUser()->getId());
            return $this->view([], Response::HTTP_NO_CONTENT);
        } catch (PostNotFoundException $e) {
            return $this->view($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
