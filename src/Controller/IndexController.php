<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserNameType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(SessionInterface $session):Response {
        if ($session->has('user_id')) {
            $user = $this->getDoctrine()->getRepository(User::class)->find($session->get('user_id'));
        } else {
            $user = new User();
        }
        $form = $this->createForm(UserNameType::class, $user,  [
            'action' => $this->generateUrl('user_register'),
        ]);

        return $this->render('default/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}