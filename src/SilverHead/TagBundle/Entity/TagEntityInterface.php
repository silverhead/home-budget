<?php

namespace App\SilverHead\TagBundle\Entity;

/**
 * Interface TaggableInterface
 * @package App\SilverHead\TagBundle\Entity
 *
 * Use TagTrait already property and methods for that
 */
interface TagEntityInterface
{
    public function setTagLabel(string $tagLabel);
    public function getTagLabel(): ?string;
}
