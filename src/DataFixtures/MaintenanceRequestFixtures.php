<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\MaintenanceRequest;
use App\Entity\Technician;
use App\Entity\Type;
use App\Entity\UserVehicle;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MaintenanceRequestFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REF_PREFIX = 'maintenance_request_';
    public const COUNT = 20;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $requestDate = $this->faker->dateTimeBetween('-2 months', '-3 days');
            $approvedDate = \DateTimeImmutable::createFromMutable((clone $requestDate)->modify('+'.$this->faker->numberBetween(1, 10).' days'));

            $request = new MaintenanceRequest();
            $request->setRequestDate($requestDate);
            $request->setApprovedDate($approvedDate);
            $request->setType($this->getRandomReference(TypeFixtures::REF_PREFIX, TypeFixtures::COUNT, Type::class));
            $request->setVehicle($this->getRandomReference(UserVehicleFixtures::REF_PREFIX, UserVehicleFixtures::COUNT, UserVehicle::class));
            $request->setTechnician($this->getRandomReference(TechnicianFixtures::REF_PREFIX, TechnicianFixtures::COUNT, Technician::class));
            $request->setCustomer($this->getRandomReference(CustomerFixtures::REF_PREFIX, CustomerFixtures::COUNT, Customer::class));

            $manager->persist($request);
            $this->addReference(self::REF_PREFIX.$i, $request);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TypeFixtures::class,
            UserVehicleFixtures::class,
            TechnicianFixtures::class,
            CustomerFixtures::class,
        ];
    }
}
