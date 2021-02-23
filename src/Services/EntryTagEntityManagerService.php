<?php


namespace App\Services;


use App\Entity\EntryTag;
use App\SilverHead\TagBundle\Services\TagEntityManagerForDataTransformerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Code\Generator\DocBlock\Tag\TagInterface;

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

    public function getNewEntityTag(): TagInterface
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
