<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/questionnaire')]
class QuestionnaireController extends AbstractController
{
    #[Route('/', methods: ['GET'])]
    public function index():Response {
        // TODO: Get last questionnaire or create new one

        return $this->render('questionnaire/index.html.twig', []);
    }

    #[Route('/answer', methods: ['POST'], condition: "service('questionnaire_check_answer').check(request)")]
    public function answer(Request $request):Response {
        // TODO: questionnaire answers here

        return $this->redirectToRoute('questionnaire_index');
    }
}