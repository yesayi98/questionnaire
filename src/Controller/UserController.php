<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserNameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends BaseController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     * @return Response
     */
    #[Route('/user', name: 'user_register', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        if ($this->getUserFromSession()) {
            return $this->redirectToRoute('questionnaire_list');
        }

        $user = new User();
        $form = $this->createForm(UserNameType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            $this->authService->setAuthUser($user);

            return $this->redirectToRoute('questionnaire_list');
        }

        return $this->redirectToRoute('homepage');
    }
}