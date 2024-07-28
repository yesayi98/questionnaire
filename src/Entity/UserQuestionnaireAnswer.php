<?php

namespace App\Entity;

use App\Repository\UserQuestionnaireAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserQuestionnaireAnswerRepository::class)]
class UserQuestionnaireAnswer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\ManyToOne]
    private ?Answer $answer = null;

    #[ORM\ManyToOne(inversedBy: 'userQuestionnaireAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserQuestionnaire $userQuestionnaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): static
    {
        $this->answer = $answer;

        return $this;
    }

    public function getUserQuestionnaire(): ?UserQuestionnaire
    {
        return $this->userQuestionnaire;
    }

    public function setUserQuestionnaire(?UserQuestionnaire $userQuestionnaire): static
    {
        $this->userQuestionnaire = $userQuestionnaire;

        return $this;
    }
}
