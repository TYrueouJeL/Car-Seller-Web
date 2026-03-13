<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Technician;
use App\Entity\Ticket;
use App\Entity\TicketStatus;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TicketFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REF_PREFIX = 'ticket_';
    public const COUNT = 20;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $ticket = new Ticket();
            $ticket->setTitle($this->faker->sentence(3));
            $ticket->setDescription($this->faker->sentence(10));
            $ticket->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-2 months', 'now')));
            $ticket->setTechnician($this->getRandomReference(TechnicianFixtures::REF_PREFIX, TechnicianFixtures::COUNT, Technician::class));
            $ticket->setCustomer($this->getRandomReference(CustomerFixtures::REF_PREFIX, CustomerFixtures::COUNT, Customer::class));
            $ticket->setStatus($this->getRandomReference(TicketStatusFixtures::REF_PREFIX, TicketStatusFixtures::COUNT, TicketStatus::class));

            $manager->persist($ticket);
            $this->addReference(self::REF_PREFIX.$i, $ticket);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TechnicianFixtures::class,
            CustomerFixtures::class,
            TicketStatusFixtures::class,
        ];
    }
}
