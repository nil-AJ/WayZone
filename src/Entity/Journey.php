<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JourneyRepository")
 */
class Journey
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $transport_type;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $society_name;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $line;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $start_point;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $stop_point;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $end_point;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="journeys")
     */
    private $user_journey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransportType(): ?string
    {
        return $this->transport_type;
    }

    public function setTransportType(string $transport_type): self
    {
        $this->transport_type = $transport_type;

        return $this;
    }

    public function getSocietyName(): ?string
    {
        return $this->society_name;
    }

    public function setSocietyName(string $society_name): self
    {
        $this->society_name = $society_name;

        return $this;
    }

    public function getLine(): ?string
    {
        return $this->line;
    }

    public function setLine(string $line): self
    {
        $this->line = $line;

        return $this;
    }

    public function getStartPoint(): ?string
    {
        return $this->start_point;
    }

    public function setStartPoint(?string $start_point): self
    {
        $this->start_point = $start_point;

        return $this;
    }

    public function getStopPoint(): ?string
    {
        return $this->stop_point;
    }

    public function setStopPoint(?string $stop_point): self
    {
        $this->stop_point = $stop_point;

        return $this;
    }

    public function getEndPoint(): ?string
    {
        return $this->end_point;
    }

    public function setEndPoint(?string $end_point): self
    {
        $this->end_point = $end_point;

        return $this;
    }

    public function getUserJourney(): ?User
    {
        return $this->user_journey;
    }

    public function setUserJourney(?User $user_journey): self
    {
        $this->user_journey = $user_journey;

        return $this;
    }
}
