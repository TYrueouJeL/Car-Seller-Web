<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\SalableVehicle;
use App\Entity\SaleOrder;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SaleOrderFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const COUNT = 20;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $order = new SaleOrder();
            $order->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-2 months', 'now')));
            $order->setCustomer($this->getRandomReference(CustomerFixtures::REF_PREFIX, CustomerFixtures::COUNT, Customer::class));
            $order->setVehicle($this->getRandomReference(SalableVehicleFixtures::REF_PREFIX, SalableVehicleFixtures::COUNT, SalableVehicle::class));

            $manager->persist($order);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerFixtures::class,
            SalableVehicleFixtures::class,
        ];
    }
}
