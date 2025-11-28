<?php

namespace App\Repository;

use App\Entity\UserVehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserVehicle>
 */
class UserVehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserVehicle::class);
    }

    public function findAllWithDetails(): array
    {
        $qb = $this->createQueryBuilder('uv')
            ->leftJoin('uv.model', 'm')
            ->addSelect('m')
            ->leftJoin('m.brand', 'b')
            ->addSelect('b')
            ->leftJoin('uv.category', 'c')
            ->addSelect('c');

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return UserVehicle[] Returns an array of UserVehicle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserVehicle
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
