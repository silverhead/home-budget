<?php

namespace App\Service;

use App\Entity\EntryTag;
use SilverHead\TagBundle\Service\TagEntityManagerForDataTransformerInterface;
use Doctrine\ORM\EntityManagerInterface;
use SilverHead\TagBundle\Entity\TagEntityInterface;

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
