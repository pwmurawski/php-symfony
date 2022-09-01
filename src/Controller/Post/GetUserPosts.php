<?php

declare(strict_types=1);

namespace App\Controller\Post;

use App\UseCase\Post\GetUserPostsUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

final class GetUserPosts extends AbstractFOSRestController
{
    private GetUserPostsUseCase $getUserPostsUseCase;

    public function __construct(GetUserPostsUseCase $getUserPostsUseCase)
    {
        $this->getUserPostsUseCase = $getUserPostsUseCase;
    }

    /**
     * @Route("/api/post/user/{id}", name="post.get.user.posts", methods={"GET"})
     */
    public function __invoke(string $id)
    {
        $postsData = $this->getUserPostsUseCase->execute($id);

        return $this->view($postsData, Response::HTTP_OK);
    }
}
