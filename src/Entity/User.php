<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $name = null;

    /**
     * @var Collection<int, UserQuestionnaire>
     */
    #[ORM\OneToMany(targetEntity: UserQuestionnaire::class, mappedBy: 'userId')]
    private Collection $userQuestionnaires;

    public function __construct()
    {
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
            $userQuestionnaire->setUserId($this);
        }

        return $this;
    }

    public function removeUserQuestionnaire(UserQuestionnaire $userQuestionnaire): static
    {
        if ($this->userQuestionnaires->removeElement($userQuestionnaire)) {
            // set the owning side to null (unless already changed)
            if ($userQuestionnaire->getUserId() === $this) {
                $userQuestionnaire->setUserId(null);
            }
        }

        return $this;
    }
}
