<?php

namespace App\DataFixtures;

use App\Entity\Supplier;
use Doctrine\Persistence\ObjectManager;

class SupplierFixtures extends BaseFixture
{
    public const REF_PREFIX = 'supplier_';
    public const COUNT = 5;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $supplier = new Supplier();
            $supplier->setName($this->faker->company());
            $supplier->setEmail($this->faker->unique()->companyEmail());

            $manager->persist($supplier);
            $this->addReference(self::REF_PREFIX.$i, $supplier);
        }

        $manager->flush();
    }
}
