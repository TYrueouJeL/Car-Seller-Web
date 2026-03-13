<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Model;
use App\Entity\RentableVehicle;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RentableVehicleFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REF_PREFIX = 'rentable_vehicle_';
    public const COUNT = 50;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $vehicle = new RentableVehicle();
            $vehicle->setModel($this->getRandomReference(ModelFixtures::REF_PREFIX, ModelFixtures::COUNT, Model::class));
            $vehicle->setCategory($this->getRandomReference(CategoryFixtures::REF_PREFIX, CategoryFixtures::COUNT, Category::class));
            $vehicle->setDailyPrice((string) $this->faker->randomFloat(2, 20, 200));
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
            CategoryFixtures::class,
        ];
    }
}
