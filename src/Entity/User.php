<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contrat_start;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contrat_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contrat_type;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Account", inversedBy="user", cascade={"persist", "remove"})
     */
    private $user_type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Journey", mappedBy="user_journey")
     */
    private $journeys;

    public function __construct()
    {
        $this->journeys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContratStart(): ?string
    {
        return $this->contrat_start;
    }

    public function setContratStart(?string $contrat_start): self
    {
        $this->contrat_start = $contrat_start;

        return $this;
    }

    public function getContratEnd(): ?string
    {
        return $this->contrat_end;
    }

    public function setContratEnd(?string $contrat_end): self
    {
        $this->contrat_end = $contrat_end;

        return $this;
    }

    public function getContratType(): ?string
    {
        return $this->contrat_type;
    }

    public function setContratType(?string $contrat_type): self
    {
        $this->contrat_type = $contrat_type;

        return $this;
    }

    public function getUserType(): ?Account
    {
        return $this->user_type;
    }

    public function setUserType(?Account $user_type): self
    {
        $this->user_type = $user_type;

        return $this;
    }

    /**
     * @return Collection|Journey[]
     */
    public function getJourneys(): Collection
    {
        return $this->journeys;
    }

    public function addJourney(Journey $journey): self
    {
        if (!$this->journeys->contains($journey)) {
            $this->journeys[] = $journey;
            $journey->setUserJourney($this);
        }

        return $this;
    }

    public function removeJourney(Journey $journey): self
    {
        if ($this->journeys->contains($journey)) {
            $this->journeys->removeElement($journey);
            // set the owning side to null (unless already changed)
            if ($journey->getUserJourney() === $this) {
                $journey->setUserJourney(null);
            }
        }

        return $this;
    }
}
