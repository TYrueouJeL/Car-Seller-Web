<?php

namespace App\DataFixtures;

use App\Entity\Supplier;
use App\Entity\SupplyOrder;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SupplyOrderFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REF_PREFIX = 'supply_order_';
    public const COUNT = 10;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $order = new SupplyOrder();
            $order->setSupplier($this->getRandomReference(SupplierFixtures::REF_PREFIX, SupplierFixtures::COUNT, Supplier::class));

            $manager->persist($order);
            $this->addReference(self::REF_PREFIX.$i, $order);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SupplierFixtures::class];
    }
}
