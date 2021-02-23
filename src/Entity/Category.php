<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use App\SilverHead\TagBundle\Entity\HasTagInterface;
use App\SilverHead\TagBundle\Entity\TagEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Code\Generator\DocBlock\Tag\TagInterface;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category implements HasTagInterface
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
    private string $label;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private Account $account;

    /**
     * @ORM\ManyToMany(targetEntity=EntryTag::class, inversedBy="categories", cascade={"persist"})
     */
    private Collection $tags;

    /**
     * @var float
     */
    private float $amount = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=7)
     */
    private string $badgeColor = "";

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return Collection|tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(TagEntityInterface $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(TagEntityInterface $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function addAmountByTag(Entry $entry): self
    {
        foreach ($this->tags as $tag) {
            if (false !== strpos(strtoupper($entry->getLabel()), strtoupper($tag->getTagLabel()))){
                $entry->addCategory($this);
                $this->amount += ($entry->getDebit()+$entry->getCredit());
                return $this;
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getBadgeColor(): string
    {
        return $this->badgeColor;
    }

    /**
     * @param string $badgeColor
     * @return Category
     */
    public function setBadgeColor(string $badgeColor): Category
    {
        $this->badgeColor = $badgeColor;

        return $this;
    }


}
