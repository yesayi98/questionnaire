<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserNameType;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends BaseController
{
    /**
     * @return Response
     */
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index():Response {
        try {
            $user = $this->getUserFromSession();
        }catch (Exception $e) {
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