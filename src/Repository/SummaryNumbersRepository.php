<?php

namespace App\Repository;

use App\Entity\SummaryNumbers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SummaryNumbers|null find($id, $lockMode = null, $lockVersion = null)
 * @method SummaryNumbers|null findOneBy(array $criteria, array $orderBy = null)
 * @method SummaryNumbers[]    findAll()
 * @method SummaryNumbers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SummaryNumbersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SummaryNumbers::class);
    }

    // /**
    //  * @return SummaryNumbers[] Returns an array of SummaryNumbers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SummaryNumbers
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
