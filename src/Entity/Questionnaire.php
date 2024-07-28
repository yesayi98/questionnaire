<?php

namespace App\Entity;

use App\Repository\QuestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionnaireRepository::class)]
class Questionnaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $name = null;

    /**
     * @var Collection<int, Question>
     */
    #[ORM\ManyToMany(targetEntity: Question::class)]
    private Collection $questions;

    /**
     * @var Collection<int, UserQuestionnaire>
     */
    #[ORM\OneToMany(targetEntity: UserQuestionnaire::class, mappedBy: 'questionnaire')]
    private Collection $userQuestionnaires;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->userQuestionnaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        $this->questions->removeElement($question);

        return $this;
    }

    /**
     * @return Collection<int, UserQuestionnaire>
     */
    public function getUserQuestionnaires(): Collection
    {
        return $this->userQuestionnaires;
    }

    public function addUserQuestionnaire(UserQuestionnaire $userQuestionnaire): static
    {
        if (!$this->userQuestionnaires->contains($userQuestionnaire)) {
            $this->userQuestionnaires->add($userQuestionnaire);
            $userQuestionnaire->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeUserQuestionnaire(UserQuestionnaire $userQuestionnaire): static
    {
        if ($this->userQuestionnaires->removeElement($userQuestionnaire)) {
            // set the owning side to null (unless already changed)
            if ($userQuestionnaire->getQuestionnaire() === $this) {
                $userQuestionnaire->setQuestionnaire(null);
            }
        }

        return $this;
    }
}
