<?php


namespace App\SilverHead\TagBundle\Services;

use Doctrine\Common\Collections\Collection;
use Zend\Code\Generator\DocBlock\Tag\TagInterface;

interface TagEntityManagerForDataTransformerInterface
{
    /**
     * Return the new instance of Tag entity
     * @return TagInterface
     */
    public function getNewEntityTag(): TagInterface;

    /**
     * Return list of Tag entity corresponding of labels list
     * @param array $labels
     * @return mixed
     */
    public function getExistTagsForLabels(array $labels);
}
