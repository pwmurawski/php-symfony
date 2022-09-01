<?php

declare(strict_types=1);

namespace App\Controller\Comment;

use App\Form\Comment\CommentPutType;
use App\UseCase\Comment\PutCommentUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use App\Exception\Comment\CommentNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Uid\Uuid;

class Put extends AbstractFOSRestController
{
    private PutCommentUseCase $putCommentUseCase;
    private FormFactoryInterface $formFactory;

    public function __construct(PutCommentUseCase $putCommentUseCase, FormFactoryInterface $formFactory)
    {
        $this->putCommentUseCase = $putCommentUseCase;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/api/comment/{commentId}", name="comment.put", methods={"PUT"})
     */
    public function __invoke(string $commentId, Request $request)
    {
        $form = $this->formFactory->createNamed('putComment', CommentPutType::class, null, [
            'commentId' => new Uuid($commentId),
            'user' => $this->getUser(),
        ]);
        $form->submit($request->request->all());

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->putCommentUseCase->execute($form->getData());

            return $this->view([], Response::HTTP_NO_CONTENT);
        } catch (CommentNotFoundException $e) {
            $form->addError(new FormError($e->getMessage()));
            return $this->view($form, Response::HTTP_NOT_FOUND);
        }
    }
}
