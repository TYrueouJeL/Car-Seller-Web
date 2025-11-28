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

    public function findAllWithDetails(): array
    {
        $qb = $this->createQueryBuilder('rv')
            ->leftJoin('rv.model', 'm')
            ->addSelect('m')
            ->leftJoin('m.brand', 'b')
            ->addSelect('b')
            ->leftJoin('rv.category', 'c')
            ->addSelect('c');

        return $qb->getQuery()->getResult();
    }

    public function findUnavailableDates(RentableVehicle $rentableVehicle): array
    {
        $unavailableDates = [];

        foreach ($rentableVehicle->getRentalOrders() as $rentalOrder)
        {
            $start = $rentalOrder->getStartDate()->format('Y-m-d');
            $end = $rentalOrder->getEndDate()->format('Y-m-d');

            $period = new \DatePeriod(
                new \DateTime($start),
                new \DateInterval('P1D'),
                (new \DateTime($end))->modify('+1 day')
            );

            foreach ($period as $date) {
                $unavailableDates[] = $date->format('Y-m-d');
            }
        }

        return $unavailableDates;
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
