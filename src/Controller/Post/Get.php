<?php

declare(strict_types=1);

namespace App\Controller\Post;

use App\UseCase\Post\GetPostUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

final class Get extends AbstractFOSRestController
{
    private GetPostUseCase $getPostUseCase;

    public function __construct(GetPostUseCase $getPostUseCase)
    {
        $this->getPostUseCase = $getPostUseCase;
    }

    /**
     * @Route("/api/post/{id}", name="post.get", methods={"GET"})
     */
    public function __invoke(string $id)
    {
        $postData = $this->getPostUseCase->execute($id);

        if (!$postData)
            return $this->view([], Response::HTTP_NOT_FOUND);
        return $this->view($postData, Response::HTTP_OK);
    }
}
