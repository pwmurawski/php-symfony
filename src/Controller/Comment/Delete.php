<?php

declare(strict_types=1);

namespace App\Controller\Comment;

use App\UseCase\Comment\DeleteCommentUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\Comment\CommentNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class Delete extends AbstractFOSRestController
{
    private DeleteCommentUseCase $deleteCommentUseCase;

    public function __construct(DeleteCommentUseCase $deleteCommentUseCase)
    {
        $this->deleteCommentUseCase = $deleteCommentUseCase;
    }

    /**
     * @Route("/api/comment/{id}", name="comment.delete", methods={"DELETE"})
     */
    public function __invoke(string $id)
    {
        try {
            $this->deleteCommentUseCase->execute($id, $this->getUser()->getId());
            return $this->view([], Response::HTTP_NO_CONTENT);
        } catch (CommentNotFoundException $e) {
            return $this->view($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
