<?php


namespace SilverHead\TagBundle\Entity;

use Doctrine\Common\Collections\Collection;

interface HasTagInterface
{
    /**
     * @return Collection|TagEntityInterface[]
     */
    public function getTags(): Collection;

    /**
     * @param TagEntityInterface $tag
     */
    public function addTag(TagEntityInterface $tag);

    /**
     * @param TagEntityInterface $tag
     */
    public function removeTag(TagEntityInterface $tag);
}
