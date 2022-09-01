<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\UseCase\User\GetUserUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

final class Get extends AbstractFOSRestController
{

    private GetUserUseCase $getUserUseCase;

    public function __construct(GetUserUseCase $getUserUseCase)
    {
        $this->getUserUseCase = $getUserUseCase;
    }

    /**
     * @Route("/api/user/{id}", name="user.get", methods={"GET"})
     */
    public function __invoke(string $id)
    {
        $user = $this->getUserUseCase->execute($id);

        if (!$user)
            return $this->view([], Response::HTTP_NOT_FOUND);
        return $this->view($user, Response::HTTP_OK);
    }
}
