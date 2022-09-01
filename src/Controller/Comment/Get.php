<?php

declare(strict_types=1);

namespace App\Controller\Comment;

use App\UseCase\Comment\GetCommentUseCase;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

class Get extends AbstractFOSRestController
{
    private GetCommentUseCase $getCommentUseCase;

    public function __construct(GetCommentUseCase $getCommentUseCase)
    {
        $this->getCommentUseCase = $getCommentUseCase;
    }

    /**
     * @Route("/api/comment/{id}", name="comment.get", methods={"GET"})
     */
    public function __invoke(string $id)
    {
        $commentData = $this->getCommentUseCase->execute($id);

        if (!$commentData)
            return $this->view([], Response::HTTP_NOT_FOUND);
        return $this->view($commentData, Response::HTTP_OK);
    }
}
