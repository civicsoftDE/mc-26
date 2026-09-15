<?php

namespace App\Repository;

use App\Entity\BandMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BandMember>
 */
class BandMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BandMember::class);
    }

    /**
     * Findet den nächsten aktiven BandMember (isOld = false).
     */
    public function findNextMember(int $currentId): ?BandMember
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id > :val')
            ->andWhere('b.isOld = :isOld')
            ->setParameter('val', $currentId)
            ->setParameter('isOld', false)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Findet den vorherigen aktiven BandMember (isOld = false).
     */
    public function findPrevMember(int $currentId): ?BandMember
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id < :val')
            ->andWhere('b.isOld = :isOld')
            ->setParameter('val', $currentId)
            ->setParameter('isOld', false)
            ->orderBy('b.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return BandMember[] Returns an array of BandMember objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BandMember
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
