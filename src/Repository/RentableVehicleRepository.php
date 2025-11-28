<?php

namespace App\Repository;

use App\Entity\RentableVehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @extends ServiceEntityRepository<RentableVehicle>
 */
class RentableVehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentableVehicle::class);
    }

    public function isRentableAt(RentableVehicle $rentableVehicle, \DateTime $startDate, \DateTime $endDate): bool
    {
        $query = $this->createQueryBuilder('rv')
            ->select('rv')
            ->where('rv.vehicle = :vehicleId')
            ->andWhere('rv.startDate <= :endDate')
            ->andWhere('rv.endDate >= :startDate')
            ->setParameter('vehicleId', $rentableVehicle->getId())
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery();

        return !empty($query->getResult());
    }

//    /**
//     * @return RentableVehicle[] Returns an array of RentableVehicle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RentableVehicle
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
