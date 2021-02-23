<?php

namespace App\Entity;

use App\Repository\EntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntryRepository::class)
 */
class Entry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $operationNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $label;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private float $debit;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private float $credit;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $date;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="entries")
     * @ORM\JoinColumn(nullable=false)
     */
    private Account $account;

    /**
     * @ORM\OneToOne(targetEntity=Periodicity::class, mappedBy="entry", cascade={"persist", "remove"})
     */
    private Periodicity $periodicity;

    /**
     * @var array
     */
    private array $categories = array();

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperationNumber(): ?string
    {
        return $this->operationNumber;
    }

    public function setOperationNumber(string $operationNumber): self
    {
        $this->operationNumber = $operationNumber;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDebit(): ?string
    {
        return $this->debit;
    }

    public function setDebit(string $debit): self
    {
        $this->debit = $debit;

        return $this;
    }

    /**
     * @return float
     */
    public function getCredit(): float
    {
        return $this->credit;
    }

    /**
     * @param float $credit
     */
    public function setCredit(float $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getPeriodicity(): ?Periodicity
    {
        return $this->periodicity;
    }

    public function setPeriodicity(Periodicity $periodicity): self
    {
        $this->periodicity = $periodicity;

        // set the owning side of the relation if necessary
        if ($periodicity->getEntry() !== $this) {
            $periodicity->setEntry($this);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param Category category
     * @return Entry
     */
    public function addCategory(Category $category): Entry
    {
        $this->categories[] = $category;

        return $this;
    }


}
