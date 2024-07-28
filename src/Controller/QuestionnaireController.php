<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Form\QuestionType;
use App\Service\AuthService;
use App\Service\QuestionnaireService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/questionnaire')]
class QuestionnaireController extends BaseController
{
    /**
     * @param AuthService $authService
     * @param QuestionnaireService $questionnaireService
     */
    public function __construct(AuthService $authService, private readonly QuestionnaireService $questionnaireService)
    {
        parent::__construct($authService);
    }

    #[Route('/', name: 'questionnaire_list', methods: ['GET'])]
    public function index():Response {
        $questionnaireService = $this->questionnaireService;
        $questionnaires = $questionnaireService->getQuestionnaireList();

        if (!count($questionnaires)) {
            return $this->redirectToRoute('questionnaire_start');
        }

        return $this->render('questionnaire/index.html.twig', [
            'user' => $this->getUserFromSession(),
            'questionnaires' => $questionnaires,
        ]);
    }

    #[Route('/{questionnaire?}/start', name: 'questionnaire_start', methods: ['GET'])]
    public function start(?Questionnaire $questionnaire):Response {
        $questionnaireService = $this->questionnaireService;
        if (!$questionnaire) {
            $userQuestionnaire = $questionnaireService->generateNewQuestionnaire();
        } else {
            $userQuestionnaire = $questionnaireService->getUserQuestionnaire($questionnaire);
        }

        return $this->render('questionnaire/detail.html.twig', [
            'user' => $this->getUserFromSession(),
            'userQuestionnaire' => $userQuestionnaire,
        ]);
    }

    /**
     * @param Questionnaire $questionnaire
     * @return RedirectResponse|Response
     */
    #[Route('/{questionnaire}/step', name: 'questionnaire_step', methods: ['GET'])]
    public function step(Questionnaire $questionnaire): RedirectResponse|Response
    {
        $questionnaireService = $this->questionnaireService;
        $question = $questionnaireService->getQuestionnaireNextQuestion($questionnaire);

        if (!$question) {
            $this->questionnaireService->finishQuestionnaire($questionnaire);
            return $this->redirectToRoute('questionnaire_result', ['questionnaire' => $questionnaire->getId()]);
        }

        $form = $this->createForm(QuestionType::class, null, [
            'question' => $question,
            'action' => $this->generateUrl('questionnaire_answer', ['questionnaire' => $questionnaire->getId()]),
        ]);

        return $this->render('questionnaire/step.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Questionnaire $questionnaire
     * @param Request $request
     * @return Response
     */
    #[Route('/{questionnaire}/answer', name: 'questionnaire_answer', methods: ['POST'])]
    public function answer(Questionnaire $questionnaire, Request $request):Response {
        $questionnaireService = $this->questionnaireService;
        $question = $questionnaireService->getQuestionById($request->get('question')['id']);
        $form = $this->createForm(QuestionType::class, null, ['question' => $question]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $questionnaireService->answerToQuestion($questionnaire, $data);
        }

        return $this->redirectToRoute('questionnaire_step', ['questionnaire' => $questionnaire->getId()]);
    }

    /**
     * @param Questionnaire $questionnaire
     * @return Response
     */
    #[Route('/{questionnaire}/result', name: 'questionnaire_result', methods: ['GET'])]
    public function result(Questionnaire $questionnaire): Response {
        $questionnaireService = $this->questionnaireService;

        $answers = $questionnaireService->getQuestionnaireResultAggregatedByQuestion($questionnaire);

        return $this->render('questionnaire/result.html.twig', [
            'questionnaire' => $questionnaire,
            'data' => $answers,
        ]);
    }
}