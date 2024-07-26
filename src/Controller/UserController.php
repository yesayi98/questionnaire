<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserNameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_register', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        $user = new User();
        $form = $this->createForm(UserNameType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            $session->set('user_id', $user->getId());

            return $this->redirectToRoute('questionnaire_start');
        }

        return $this->redirectToRoute('homepage');
    }
}