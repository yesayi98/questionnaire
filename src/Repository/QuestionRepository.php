<?php

namespace App\Repository;

use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Entity\UserQuestionnaire;
use App\Entity\UserQuestionnaireAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 */
class QuestionRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * Get a random subset of questions
     *
     * @param int $numberOfQuestions
     * @return Question[]
     */
    public function getQuestions(int $numberOfQuestions): array
    {
        // Use DQL to fetch random questions
        $qb = $this->createQueryBuilder('q')
            ->setMaxResults($numberOfQuestions);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param UserQuestionnaire $userQuestionnaire
     * @return Question|null
     */
    public function findFirstUnansweredQuestion (UserQuestionnaire $userQuestionnaire): ?Question {
        $qb = $this->createQueryBuilder('q')
            ->leftJoin(UserQuestionnaireAnswer::class, 'uqa',
                'WITH',
                'uqa.question = q.id AND uqa.userQuestionnaire = :userQuestionnaire')
                ->andWhere('uqa IS NULL')
            ->setParameter('userQuestionnaire', $userQuestionnaire)
        ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
