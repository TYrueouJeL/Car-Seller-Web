<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Model;
use App\Entity\UserVehicle;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserVehicleFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REF_PREFIX = 'user_vehicle_';
    public const COUNT = 100;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $vehicle = new UserVehicle();
            $vehicle->setModel($this->getRandomReference(ModelFixtures::REF_PREFIX, ModelFixtures::COUNT, Model::class));
            $vehicle->setCustomer($this->getRandomReference(CustomerFixtures::REF_PREFIX, CustomerFixtures::COUNT, Customer::class));
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
            CustomerFixtures::class,
        ];
    }
}
