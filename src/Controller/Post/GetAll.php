<?php

declare(strict_types=1);

namespace App\Controller\Post;

use App\UseCase\Post\GetAllPostUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

final class GetAll extends AbstractFOSRestController
{
    private GetAllPostUseCase $getAllPostUseCase;

    public function __construct(GetAllPostUseCase $getAllPostUseCase)
    {
        $this->getAllPostUseCase = $getAllPostUseCase;
    }

    /**
     * @Route("/api/posts", name="post.get.all", methods={"GET"})
     */
    public function __invoke()
    {
        $postData = $this->getAllPostUseCase->execute();

        return $this->view($postData, Response::HTTP_OK);
    }
}
