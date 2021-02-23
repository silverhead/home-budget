<?php

namespace App\Entity;

use App\Repository\SoldeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SoldeRepository::class)
 */
class Solde
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=entry::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $entry;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $amount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntry(): ?entry
    {
        return $this->entry;
    }

    public function setEntry(entry $entry): self
    {
        $this->entry = $entry;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
