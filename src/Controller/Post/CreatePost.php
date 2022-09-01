<?php

declare(strict_types=1);

namespace App\Controller\Post;

use Symfony\Component\Uid\Uuid;
use App\Form\Post\PostCreateType;
use App\UseCase\Post\CreatePostUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;

final class CreatePost extends AbstractFOSRestController
{
    private FormFactoryInterface $formFactory;
    private CreatePostUseCase $createPostUseCase;

    public function __construct(FormFactoryInterface $formFactory, CreatePostUseCase $createPostUseCase)
    {
        $this->formFactory = $formFactory;
        $this->createPostUseCase = $createPostUseCase;
    }

    /**
     * @Route("/api/post", name="post.post", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $id = Uuid::v4();

        $form = $this->formFactory->createNamed('post', PostCreateType::class, null, [
            'postId' => $id,
            'user' => $this->getUser()
        ]);
        $form->submit($request->request->all());

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->createPostUseCase->execute($form->getData());

        return $this->view([
            'id' => $id,
        ], Response::HTTP_OK);
    }
}
