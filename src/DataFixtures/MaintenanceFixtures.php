<?php

namespace App\DataFixtures;

use App\Entity\Maintenance;
use App\Entity\MaintenanceRequest;
use App\Entity\MaintenanceStatus;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MaintenanceFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const COUNT = 20;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $request = $this->getReference(\App\DataFixtures\MaintenanceRequestFixtures::REF_PREFIX.$i, MaintenanceRequest::class);
            $maintenanceDate = $this->faker->dateTimeBetween($request->getRequestDate()->format('Y-m-d H:i:s'), 'now');

            $maintenance = new Maintenance();
            $maintenance->setDate($maintenanceDate);
            $maintenance->setMaintenanceRequest($request);
            $maintenance->setCustomer($request->getCustomer());
            $maintenance->setTechnician($request->getTechnician());
            $maintenance->setType($request->getType());
            $maintenance->setVehicle($request->getVehicle());
            $maintenance->setMaintenanceStatus($this->getRandomReference(\App\DataFixtures\MaintenanceStatusFixtures::REF_PREFIX, \App\DataFixtures\MaintenanceStatusFixtures::COUNT, MaintenanceStatus::class));

            $manager->persist($maintenance);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            \App\DataFixtures\MaintenanceRequestFixtures::class,
            \App\DataFixtures\MaintenanceStatusFixtures::class,
        ];
    }
}
