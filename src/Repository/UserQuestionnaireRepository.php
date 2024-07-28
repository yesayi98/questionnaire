<?php

namespace App\Repository;

use App\Entity\Questionnaire;
use App\Entity\User;
use App\Entity\UserQuestionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserQuestionnaire>
 */
class UserQuestionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserQuestionnaire::class);
    }

    public function getUserLastQuestionnaire(User $user, Questionnaire $questionnaire, bool $finished) {
        $qb = $this->createQueryBuilder('u')
            ->leftJoin('u.questionnaire', 'q')
            ->leftJoin('u.userQuestionnaireAnswers', 'uqa')
            ->addSelect('uqa')
            ->orderBy('u.id', 'DESC')
            ->where('u.userId = :user')
            ->andWhere('u.isFinished = :isFinished')
            ->andWhere('q = :questionnaire')
            ->setParameter('user', $user)
            ->setParameter('isFinished', $finished)
            ->setParameter('questionnaire', $questionnaire);

        return $qb->getQuery()->getResult()[0];
    }
}
