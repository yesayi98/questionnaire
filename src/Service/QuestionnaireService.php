<?php

namespace App\Service;

use App\Entity\Question;
use App\Entity\UserQuestionnaire;
use App\Entity\UserQuestionnaireAnswer;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Questionnaire;

class QuestionnaireService
{
    const NUMBER_OF_QUESTIONS = 10;

    /**
     * @param AuthService $authService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly AuthService $authService, private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @return array
     */
    public function getQuestionnaireList(): array
    {
        return $this->entityManager->getRepository(Questionnaire::class)->findAll();
    }

    /**
     * @return UserQuestionnaire
     */
    public function generateNewQuestionnaire(): UserQuestionnaire
    {
        $questionRepository = $this->entityManager->getRepository(Question::class);

        $questions = $questionRepository->getQuestions(self::NUMBER_OF_QUESTIONS);

        $questionnaire = new Questionnaire();

        $questionnaire->setName('Math'); // TODO: expected to be a type of questionnaire
        foreach ($questions as $question) {
            $questionnaire->addQuestion($question);
        }

        $this->entityManager->persist($questionnaire);
        $this->entityManager->flush();

        return $this->generateUserQuestionnaire($questionnaire);
    }

    /**
     * @param Questionnaire $questionnaire
     * @return UserQuestionnaire
     */
    public function getUserQuestionnaire(Questionnaire $questionnaire): UserQuestionnaire
    {
        $questionnaireRepository = $this->entityManager->getRepository(UserQuestionnaire::class);
        $user = $this->authService->getAuthUser();

        return $questionnaireRepository->findOneBy(['questionnaire' => $questionnaire, 'userId' => $user, 'isFinished' => false]) ?? $this->generateUserQuestionnaire($questionnaire);
    }

    /**
     * @param Questionnaire $questionnaire
     * @return UserQuestionnaire
     */
    private function generateUserQuestionnaire(Questionnaire $questionnaire): UserQuestionnaire
    {
        $user = $this->authService->getAuthUser();
        $userQuestionnaire = new UserQuestionnaire();
        $userQuestionnaire->setUserId($user);
        $userQuestionnaire->setQuestionnaire($questionnaire);
        $userQuestionnaire->setFinished(false);

        $this->entityManager->persist($userQuestionnaire);

        $this->entityManager->flush();

        return $userQuestionnaire;
    }

    /**
     * @param Questionnaire $questionnaire
     * @return Question|null
     */
    public function getQuestionnaireNextQuestion(Questionnaire $questionnaire): ?Question
    {
        $userQuestionnaire = $this->getUserQuestionnaire($questionnaire);

        $questionRepository = $this->entityManager->getRepository(Question::class);
        return $questionRepository->findFirstUnansweredQuestion($userQuestionnaire);
    }

    /**
     * @param Questionnaire $questionnaire
     * @return void
     */
    public function finishQuestionnaire(Questionnaire $questionnaire): void
    {
        $userQuestionnaire = $this->getUserQuestionnaire($questionnaire);
        $userQuestionnaire->setFinished(true);
        $this->entityManager->persist($userQuestionnaire);
        $this->entityManager->flush();
    }

    /**
     * @param Questionnaire $questionnaire
     * @param array $data
     * @return void
     */
    public function answerToQuestion(Questionnaire $questionnaire, array $data): void
    {
        $userQuestionnaire = $this->getUserQuestionnaire($questionnaire);

        foreach ($data['answers'] as $answer) {
            $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
            $userQuestionnaireAnswer->setUserQuestionnaire($userQuestionnaire);
            $userQuestionnaireAnswer->setQuestion($this->entityManager->getRepository(Question::class)->find($data['id']));
            $userQuestionnaireAnswer->setAnswer($answer);
            $this->entityManager->persist($userQuestionnaireAnswer);
        }

        $this->entityManager->flush();
    }

    /**
     * @param int $id
     * @return Question|null
     */
    public function getQuestionById(int $id): ?Question
    {
        $questionRepository = $this->entityManager->getRepository(Question::class);
        return $questionRepository->find($id);
    }

    /**
     * @param Questionnaire $questionnaire
     * @return UserQuestionnaire
     */
    private function getUserFinishedQuestionnaire(Questionnaire $questionnaire): UserQuestionnaire
    {
        $user = $this->authService->getAuthUser();
        return $this->entityManager->getRepository(UserQuestionnaire::class)->getUserLastQuestionnaire($user, $questionnaire, true);
    }

    /**
     * @return array{right: array, wrong: array}
     */
    public function getQuestionnaireResultAggregatedByQuestion(Questionnaire $questionnaire): array
    {
        $rightAnswers = [];
        $wrongAnswers = [];
        $finishedUserQuestionnaire = $this->getUserFinishedQuestionnaire($questionnaire);
        $userAnswers = $finishedUserQuestionnaire->getUserQuestionnaireAnswers();

        foreach ($userAnswers as $userAnswer) {
            $answer = $userAnswer->getAnswer();
            $isAnswerRight = $answer->isRight();
            $question = $userAnswer->getQuestion();
            $answers[$question->getId()][] = $isAnswerRight;
            if ($isAnswerRight) {
                $rightAnswers[$question->getId()] = $question->getTitle();
            } else {
                $wrongAnswers[$question->getId()] = $question->getTitle();
                unset ($rightAnswers[$question->getId()]);
            }
        }

        return [
            'right' => $rightAnswers,
            'wrong' => $wrongAnswers,
        ];
    }
}