<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthService
{
    public function __construct(private readonly RequestStack $requestStack, private readonly EntityManagerInterface $entityManager)
    {
    }

    public function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }

    public function getAuthUser() {
        $userId = $this->getSession()->get('user_id');
        if (!$userId) {
           return null;
        }

        return $this->entityManager->getRepository(User::class)->find($userId);
    }

    public function setUserToSession(int $userId): void
    {
        $this->getSession()->remove('user_id');
        $this->getSession()->set('user_id', $userId);
    }

    public function setAuthUser (User $user): void {
        $this->setUserToSession($user->getId());
    }
}