<?php

declare(strict_types=1);

namespace App\Controller\Comment;

use Symfony\Component\Uid\Uuid;
use App\Form\Comment\CommentCreateType;
use App\UseCase\Comment\CreateCommentUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class Post extends AbstractFOSRestController
{
    private FormFactoryInterface $formFactory;
    private CreateCommentUseCase $createCommentUseCase;

    public function __construct(
        FormFactoryInterface $formFactory,
        CreateCommentUseCase $createCommentUseCase
    ) {
        $this->formFactory = $formFactory;
        $this->createCommentUseCase = $createCommentUseCase;
    }

    /**
     * @Route("/api/comment", name="comment.post", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $id = Uuid::v4();

        $form = $this->formFactory->createNamed('comment', CommentCreateType::class, null, [
            'commentId' => $id,
            'user' => $this->getUser()
        ]);
        $form->submit($request->request->all());

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->createCommentUseCase->execute($form->getData());

        return $this->view([
            'id' => $id,
        ], Response::HTTP_OK);
    }
}
