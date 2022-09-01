<?php

declare(strict_types=1);

namespace App\Controller\SavedPost;

use Symfony\Component\Uid\Uuid;
use App\Form\SavedPost\SavedPostType;
use Symfony\Component\HttpFoundation\Request;
use App\UseCase\SavedPost\AddSavedPostUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class Post extends AbstractFOSRestController
{
    private AddSavedPostUseCase $addSavedPostUseCase;
    private FormFactoryInterface $formFactory;

    public function __construct(AddSavedPostUseCase $addSavedPostUseCase, FormFactoryInterface $formFactory)
    {
        $this->addSavedPostUseCase = $addSavedPostUseCase;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/api/savedPost", name="savedPost.post", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $id = Uuid::v4();
        $userId = $this->getUser()->getId();

        $form = $this->formFactory->createNamed('savedPost', SavedPostType::class, null, [
            'savedPostId' => $id,
            'userId' => $userId
        ]);
        $form->submit($request->request->all());

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->addSavedPostUseCase->execute($form->getData());

        return $this->view([
            'id' => $id,
        ], Response::HTTP_OK);
    }
}
