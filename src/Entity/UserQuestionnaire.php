<?php

namespace App\Entity;

use App\Repository\UserQuestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserQuestionnaireRepository::class)]
class UserQuestionnaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Questionnaire $questionnaire = null;

    #[ORM\ManyToOne(inversedBy: 'userQuestionnaires')]
    private ?User $userId = null;

    #[ORM\Column]
    private ?bool $isFinished = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, UserQuestionnaireAnswer>
     */
    #[ORM\OneToMany(targetEntity: UserQuestionnaireAnswer::class, mappedBy: 'userQuestionnaire', orphanRemoval: true)]
    private Collection $userQuestionnaireAnswers;

    public function __construct()
    {
        $this->userQuestionnaireAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?Questionnaire $questionnaire): static
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function isFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setFinished(bool $isFinished): static
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, UserQuestionnaireAnswer>
     */
    public function getUserQuestionnaireAnswers(): Collection
    {
        return $this->userQuestionnaireAnswers;
    }

    public function addUserQuestionnaireAnswer(UserQuestionnaireAnswer $userQuestionnaireAnswer): static
    {
        if (!$this->userQuestionnaireAnswers->contains($userQuestionnaireAnswer)) {
            $this->userQuestionnaireAnswers->add($userQuestionnaireAnswer);
            $userQuestionnaireAnswer->setUserQuestionnaire($this);
        }

        return $this;
    }

    public function removeUserQuestionnaireAnswer(UserQuestionnaireAnswer $userQuestionnaireAnswer): static
    {
        if ($this->userQuestionnaireAnswers->removeElement($userQuestionnaireAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userQuestionnaireAnswer->getUserQuestionnaire() === $this) {
                $userQuestionnaireAnswer->setUserQuestionnaire(null);
            }
        }

        return $this;
    }
}
