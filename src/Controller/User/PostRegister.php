<?php

declare(strict_types=1);

namespace App\Controller\User;

use Symfony\Component\Uid\Uuid;
use App\Form\User\RegisterUserType;
use App\UseCase\User\RegisterUserUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;

final class PostRegister extends AbstractFOSRestController
{
    private FormFactoryInterface $formFactory;
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(
        FormFactoryInterface $formFactory,
        RegisterUserUseCase $registerUserUseCase
    ) {
        $this->formFactory = $formFactory;
        $this->registerUserUseCase = $registerUserUseCase;
    }

    /**
     * @Route("/api/register", name="user.register", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $userId = Uuid::v4();

        $form = $this->formFactory->createNamed('user', RegisterUserType::class, null, ['userId' => $userId]);
        $form->submit($request->request->all());

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->registerUserUseCase->execute($form->getData());

        return $this->view([
            'id' => $userId,
        ], Response::HTTP_OK);
    }
}
