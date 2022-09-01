<?php

declare(strict_types=1);

namespace App\Controller\Post;

use App\UseCase\Post\GetUserAuthPostsUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class GetUserAuthPosts extends AbstractFOSRestController
{
    private GetUserAuthPostsUseCase $getUserAuthPostsUseCase;

    public function __construct(GetUserAuthPostsUseCase $getUserAuthPostsUseCase)
    {
        $this->getUserAuthPostsUseCase = $getUserAuthPostsUseCase;
    }

    /**
     * @Route("/api/user/posts", name="post.get.post.userAuth", methods={"GET"})
     */
    public function __invoke()
    {
        $posts = $this->getUserAuthPostsUseCase->execute($this->getUser()->getId());

        return $this->view($posts, Response::HTTP_OK);
    }
}
