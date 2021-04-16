<?php

namespace SilverHead\TagBundle\Service;

use SilverHead\TagBundle\Entity\TagEntityInterface;

interface TagEntityManagerForDataTransformerInterface
{
    /**
     * Return the new instance of Tag entity
     * @return TagInterface
     */
    public function getNewEntityTag(): TagEntityInterface;

    /**
     * Return list of Tag entity corresponding of labels list
     * @param array $labels
     * @return mixed
     */
    public function getExistTagsForLabels(array $labels);
}
