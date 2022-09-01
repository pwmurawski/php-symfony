<?php

declare(strict_types=1);

namespace App\Controller\Comment;

use Symfony\Component\HttpFoundation\Response;
use App\UseCase\Comment\GetPostCommentsUseCase;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class GetPostComments extends AbstractFOSRestController
{
    private GetPostCommentsUseCase $getPostCommentsUseCase;

    public function __construct(GetPostCommentsUseCase $getPostCommentsUseCase)
    {
        $this->getPostCommentsUseCase = $getPostCommentsUseCase;
    }

    /**
     * @Route("/api/comment/post/{id}", name="comment.get.post.comments", methods={"GET"})
     */
    public function __invoke(string $id)
    {
        $comments = $this->getPostCommentsUseCase->execute($id);

        return $this->view($comments, Response::HTTP_OK);
    }
}
