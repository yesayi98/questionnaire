<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    /**
     * @param AuthService $authService
     */
    public function __construct(protected readonly AuthService $authService)
    {
    }

    /**
     * @return User|null
     */
    protected function getUserFromSession(): ?User
    {
        return $this->authService->getAuthUser();
    }
}
