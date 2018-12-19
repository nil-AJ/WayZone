<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DelayRepository")
 */
class Delay
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $delay_time;

    /**
     * @ORM\Column(type="datetime")
     */
    private $delay_day;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Transport", inversedBy="delays")
     */
    private $transport_delay;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDelayTime(): ?int
    {
        return $this->delay_time;
    }

    public function setDelayTime(int $delay_time): self
    {
        $this->delay_time = $delay_time;

        return $this;
    }

    public function getDelayDay(): ?\DateTimeInterface
    {
        return $this->delay_day;
    }

    public function setDelayDay(\DateTimeInterface $delay_day): self
    {
        $this->delay_day = $delay_day;

        return $this;
    }

    public function getTransportDelay(): ?Transport
    {
        return $this->transport_delay;
    }

    public function setTransportDelay(?Transport $transport_delay): self
    {
        $this->transport_delay = $transport_delay;

        return $this;
    }


}
