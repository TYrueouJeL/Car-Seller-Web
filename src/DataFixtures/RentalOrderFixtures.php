<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\RentableVehicle;
use App\Entity\RentalOrder;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RentalOrderFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const COUNT = 20;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
            $endDate = (clone $startDate)->modify('+'.$this->faker->numberBetween(1, 14).' days');

            $order = new RentalOrder();
            $order->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-2 months', 'now')));
            $order->setCustomer($this->getRandomReference(CustomerFixtures::REF_PREFIX, CustomerFixtures::COUNT, Customer::class));
            $order->setVehicle($this->getRandomReference(RentableVehicleFixtures::REF_PREFIX, RentableVehicleFixtures::COUNT, RentableVehicle::class));
            $order->setStartDate($startDate);
            $order->setEndDate($endDate);

            $manager->persist($order);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerFixtures::class,
            RentableVehicleFixtures::class,
        ];
    }
}
