<?php

namespace App\DataFixtures;

use App\Entity\Feature;
use App\Entity\RentableVehicle;
use App\Entity\SalableVehicle;
use App\Entity\UserVehicle;
use App\Entity\VehicleFeature;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VehicleFeatureFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $vehicles = [];

        for ($i = 0; $i < \App\DataFixtures\UserVehicleFixtures::COUNT; ++$i) {
            $vehicles[] = $this->getReference(\App\DataFixtures\UserVehicleFixtures::REF_PREFIX.$i, UserVehicle::class);
        }
        for ($i = 0; $i < \App\DataFixtures\RentableVehicleFixtures::COUNT; ++$i) {
            $vehicles[] = $this->getReference(\App\DataFixtures\RentableVehicleFixtures::REF_PREFIX.$i, RentableVehicle::class);
        }
        for ($i = 0; $i < \App\DataFixtures\SalableVehicleFixtures::COUNT; ++$i) {
            $vehicles[] = $this->getReference(\App\DataFixtures\SalableVehicleFixtures::REF_PREFIX.$i, SalableVehicle::class);
        }

        foreach ($vehicles as $vehicle) {
            $featureIndexes = range(0, \App\DataFixtures\FeatureFixtures::COUNT - 1);
            shuffle($featureIndexes);
            $selection = array_slice($featureIndexes, 0, $this->faker->numberBetween(1, \App\DataFixtures\FeatureFixtures::COUNT));

            foreach ($selection as $featureIndex) {
                $vehicleFeature = new VehicleFeature();
                $vehicleFeature->setVehicle($vehicle);
                $vehicleFeature->setFeature($this->getReference(\App\DataFixtures\FeatureFixtures::REF_PREFIX.$featureIndex, Feature::class));

                $manager->persist($vehicleFeature);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            \App\DataFixtures\FeatureFixtures::class,
            \App\DataFixtures\UserVehicleFixtures::class,
            \App\DataFixtures\RentableVehicleFixtures::class,
            \App\DataFixtures\SalableVehicleFixtures::class,
        ];
    }
}
