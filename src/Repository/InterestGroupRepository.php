<?php

namespace App\Repository;

use App\Entity\InterestGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InterestGroup>
 *
 * @method InterestGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterestGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterestGroup[]    findAll()
 * @method InterestGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterestGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterestGroup::class);
    }

    //    /**
    //     * @return InterestGroup[] Returns an array of InterestGroup objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?InterestGroup
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
