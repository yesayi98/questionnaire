<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user', methods: ['PUT'], condition: "service('user_check').check(request)")]
    public function update(Request $request): JsonResponse
    {

        return $this->json([]);
    }
}