<?php

namespace App\Services;

use App\Entity\EntryTag;
use App\SilverHead\TagBundle\Services\TagEntityManagerForDataTransformerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\SilverHead\TagBundle\Entity\TagEntityInterface;

class EntryTagEntityManagerService implements TagEntityManagerForDataTransformerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getNewEntityTag(): TagEntityInterface
    {
        return new EntryTag();
    }

    public function getExistTagsForLabels(array $labels)
    {
        return $this->entityManager->getRepository(EntryTag::class)->findBy([
            'tagLabel' => $labels
        ]);
    }

}
