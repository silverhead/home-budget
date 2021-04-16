<?php


namespace SilverHead\TagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait TagTrait
{
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $tagLabel = "";

    public function __toString()
    {
        return $this->tagLabel;
    }

    /**
     * @param string $tagLabel
     * @return $this
     */
    public function setTagLabel(string $tagLabel): self
    {
        $this->tagLabel = $tagLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getTagLabel(): ?string{
        return $this->tagLabel;
    }
}
