<?php

namespace App\Repository;

use App\Entity\SalableVehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalableVehicle>
 */
class SalableVehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalableVehicle::class);
    }

    public function findAllWithDetails(): array
    {
        $qb = $this->createQueryBuilder('sv')
            ->leftJoin('sv.model', 'm')
            ->addSelect('m')
            ->leftJoin('m.brand', 'b')
            ->addSelect('b')
            ->leftJoin('sv.category', 'c')
            ->addSelect('c');

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return SalableVehicle[] Returns an array of SalableVehicle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SalableVehicle
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
