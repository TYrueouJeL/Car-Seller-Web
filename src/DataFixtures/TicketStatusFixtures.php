<?php

namespace App\DataFixtures;

use App\Entity\TicketStatus;
use Doctrine\Persistence\ObjectManager;

class TicketStatusFixtures extends BaseFixture
{
    public const REF_PREFIX = 'ticket_status_';
    public const COUNT = 3;

    public function load(ObjectManager $manager): void
    {
        foreach (['Declare', 'En cours', 'Resolu'] as $index => $name) {
            $status = new TicketStatus();
            $status->setName($name);

            $manager->persist($status);
            $this->addReference(self::REF_PREFIX.$index, $status);
        }

        $manager->flush();
    }
}
