<?php

namespace App\SilverHead\Form\DataTransformer;

use App\SilverHead\TagBundle\Services\TagEntityManagerForDataTransformerInterface;
use Symfony\Component\Form\DataTransformerInterface;

class TagTransformer implements DataTransformerInterface
{
    /**
     * @var TagEntityManagerForDataTransformerInterface
     */
    private TagEntityManagerForDataTransformerInterface $manager;

    public function __construct(TagEntityManagerForDataTransformerInterface $entityManagerForDataTransformer)
    {
        $this->manager = $entityManagerForDataTransformer;
    }

    public function transform($value): string
    {
        return implode(',', $value);
    }

    public function reverseTransform($value): array
    {
        $labels = explode(',', $value);
        $tags = $this->manager->getExistTagsForLabels($labels);

        $newTags = array_diff($labels, $tags);
        foreach ($newTags as $newTag) {
            $tag = $this->manager->getExistTagsForLabels();
            $tag->setLabel($newTag);

            $tags[] = $tag;
        }
        return $tags;
    }
}
