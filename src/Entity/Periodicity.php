<?php

namespace App\Entity;

use App\Repository\PeriodicityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PeriodicityRepository::class)
 */
class Periodicity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $periodicity;

    /**
     * @ORM\Column(type="integer")
     */
    private $periodicityType;

    /**
     * @ORM\OneToOne(targetEntity=Entry::class, inversedBy="periodicity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $entry;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriodicity(): ?int
    {
        return $this->periodicity;
    }

    public function setPeriodicity(int $periodicity): self
    {
        $this->periodicity = $periodicity;

        return $this;
    }

    public function getPeriodicityType(): ?int
    {
        return $this->periodicityType;
    }

    public function setPeriodicityType(int $periodicityType): self
    {
        $this->periodicityType = $periodicityType;

        return $this;
    }

    public function getEntry(): ?Entry
    {
        return $this->entry;
    }

    public function setEntry(Entry $entry): self
    {
        $this->entry = $entry;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
}
