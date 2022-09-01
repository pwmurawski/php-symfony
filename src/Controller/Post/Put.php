<?php

declare(strict_types=1);

namespace App\Controller\Post;

use App\Form\Post\PostPutType;
use Symfony\Component\Uid\Uuid;
use App\UseCase\Post\PutPostUseCase;
use Symfony\Component\Form\FormError;
use App\Exception\Post\PostNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class Put extends AbstractFOSRestController
{
    private FormFactoryInterface $formFactory;
    private PutPostUseCase $putPostUseCase;

    public function __construct(FormFactoryInterface $formFactory, PutPostUseCase $putPostUseCase)
    {
        $this->formFactory = $formFactory;
        $this->putPostUseCase = $putPostUseCase;
    }

    /**
     * @Route("/api/post/{postId}", name="post.put", methods={"PUT"})
     */
    public function __invoke(string $postId, Request $request)
    {
        $form = $this->formFactory->createNamed('PutPost', PostPutType::class, null, [
            'postId' => new Uuid($postId),
            'user' => $this->getUser(),
        ]);
        $form->submit($request->request->all());

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->putPostUseCase->execute($form->getData());

            return $this->view([], Response::HTTP_NO_CONTENT);
        } catch (PostNotFoundException $e) {
            $form->addError(new FormError($e->getMessage()));
            return $this->view($form, Response::HTTP_NOT_FOUND);
        }
    }
}
