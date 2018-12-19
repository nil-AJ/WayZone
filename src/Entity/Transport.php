<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransportRepository")
 */
class Transport
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
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $short_code_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cause;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $brut_delay;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Delay", mappedBy="transport_delay")
     */
    private $delays;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $id_unique;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $line;

    public function __construct()
    {
        $this->delays = new ArrayCollection();
    }

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

    public function getShortCodeName(): ?string
    {
        return $this->short_code_name;
    }

    public function setShortCodeName(?string $short_code_name): self
    {
        $this->short_code_name = $short_code_name;

        return $this;
    }

    public function getCause(): ?string
    {
        return $this->cause;
    }

    public function setCause(string $cause): self
    {
        $this->cause = $cause;

        return $this;
    }

    public function getBrutDelay(): ?string
    {
        return $this->brut_delay;
    }

    public function setBrutDelay(string $brut_delay): self
    {
        $this->brut_delay = $brut_delay;

        return $this;
    }

    /**
     * @return Collection|Delay[]
     */
    public function getDelays(): Collection
    {
        return $this->delays;
    }

    public function addDelay(Delay $delay): self
    {
        if (!$this->delays->contains($delay)) {
            $this->delays[] = $delay;
            $delay->setTransportDelay($this);
        }

        return $this;
    }

    public function removeDelay(Delay $delay): self
    {
        if ($this->delays->contains($delay)) {
            $this->delays->removeElement($delay);
            // set the owning side to null (unless already changed)
            if ($delay->getTransportDelay() === $this) {
                $delay->setTransportDelay(null);
            }
        }

        return $this;
    }

    public function getTransportId(): ?string
    {
        return $this->transport_id;
    }

    public function setTransportId(?string $transport_id): self
    {
        $this->transport_id = $transport_id;

        return $this;
    }

    public function getIdUnique(): ?string
    {
        return $this->id_unique;
    }

    public function setIdUnique(?string $id_unique): self
    {
        $this->transport_id = $id_unique;

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
}
