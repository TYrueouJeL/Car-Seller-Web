<?php

namespace App\DataFixtures;

use App\Entity\Model;
use App\Entity\SalableVehicle;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SalableVehicleFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REF_PREFIX = 'salable_vehicle_';
    public const COUNT = 50;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $vehicle = new SalableVehicle();
            $vehicle->setModel($this->getRandomReference(ModelFixtures::REF_PREFIX, ModelFixtures::COUNT, Model::class));
            $vehicle->setPrice((string) $this->faker->randomFloat(2, 5000, 50000));
            $vehicle->setYear((int) $this->faker->year());
            $vehicle->setMileage((string) $this->faker->randomFloat(2, 0, 100000));
            $vehicle->setRegistration(strtoupper($this->faker->bothify('??-###-??')));

            $manager->persist($vehicle);
            $this->addReference(self::REF_PREFIX.$i, $vehicle);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ModelFixtures::class,
        ];
    }
}
