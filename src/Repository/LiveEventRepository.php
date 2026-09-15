<?php

namespace App\Repository;

use App\Entity\LiveEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LiveEvent>
 */
class LiveEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LiveEvent::class);
    }

    /**
     * Findet alle Konzerte, die in der Vergangenheit liegen (startDate < jetzt).
     */
    public function findPastConcerts(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.startsAt < :now')
            ->setParameter('now', new \DateTimeImmutable()) // oder new \DateTime()
            ->orderBy('c.startsAt', 'DESC') // Optional: neueste zuerst
            ->getQuery()
            ->getResult();
    }

    /**
     * Findet alle zukünftigen Konzerte (startDate >= jetzt).
     */
    public function findUpcomingConcerts(int $limit = 6): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.startsAt >= :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('c.startsAt', 'ASC')
            ->getQuery()
            ->setMaxResults($limit)
            ->getResult();
    }

//    /**
//     * @return LiveEvent[] Returns an array of LiveEvent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LiveEvent
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
