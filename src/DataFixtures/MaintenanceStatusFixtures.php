<?php

namespace App\DataFixtures;

use App\Entity\MaintenanceStatus;
use Doctrine\Persistence\ObjectManager;

class MaintenanceStatusFixtures extends BaseFixture
{
    public const REF_PREFIX = 'maintenance_status_';
    public const COUNT = 3;

    public function load(ObjectManager $manager): void
    {
        foreach (['En attente', 'En cours', 'Terminee'] as $index => $name) {
            $status = new MaintenanceStatus();
            $status->setName($name);

            $manager->persist($status);
            $this->addReference(self::REF_PREFIX.$index, $status);
        }

        $manager->flush();
    }
}
