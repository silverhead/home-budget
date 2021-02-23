<?php

namespace App\Repository;

use App\Entity\Entry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entry[]    findAll()
 * @method Entry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entry::class);
    }

    public function getByPeriodAndAccount(int $accountId, \Datetime $dateStart, \Datetime $dateEnd, array $orders = array())
    {
        $from = new \DateTime($dateStart->format("Y-m-d")." 00:00:00");
        $to   = new \DateTime($dateEnd->format("Y-m-d")." 23:59:59");

        $qb = $this->createQueryBuilder("e");
        $qb
            ->andWhere('e.account = :account')
                ->setParameter('account', $accountId)
            ->andWhere('e.date BETWEEN :from AND :to')
                ->setParameter('from', $from )
                ->setParameter('to', $to)
        ;

        if (count($orders) > 0){
            foreach ($orders as $orderKey => $orderValue) {
                $qb->addOrderBy($orderKey, $orderValue);
            }
        }

        return $qb->getQuery()->getResult();
    }

    public function getSoldTotalEndPeriod(int $accountId, \DateTime $dateEnd)
    {
        $to   = new \DateTime($dateEnd->format("Y-m-d")." 23:59:59");

        $qb = $this->createQueryBuilder("e");
        $qb
            ->select('(SUM(e.credit)+SUM(e.debit)) AS totalPeriod')
            ->andWhere('e.account = :account')
            ->setParameter('account', $accountId)
            ->andWhere('e.date <= :to')
            ->setParameter('to', $to)
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getEntryDistinctLabels()
    {
        $qb = $this->createQueryBuilder("e");
        $qb->select("e.label")
           ->distinct();
        $result = $qb->getQuery()->getScalarResult();
        $singleArray = array();

        foreach ($result as $entryLabel) {
            $singleArray[] = $entryLabel['label'];
        }
        return $singleArray;
    }

    // /**
    //  * @return Entry[] Returns an array of Entry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entry
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
