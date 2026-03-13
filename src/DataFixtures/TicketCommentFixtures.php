<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use App\Entity\TicketComment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TicketCommentFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < \App\DataFixtures\TicketFixtures::COUNT; ++$i) {
            $ticket = $this->getReference(\App\DataFixtures\TicketFixtures::REF_PREFIX.$i, Ticket::class);
            for ($c = 0; $c < 3; ++$c) {
                $comment = new TicketComment();
                $comment->setComment($this->faker->sentence(8));
                $comment->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween($ticket->getCreatedAt()->format('Y-m-d H:i:s'), 'now')));
                $comment->setTicket($ticket);
                $comment->setAuthor($this->faker->randomElement([$ticket->getCustomer(), $ticket->getTechnician()]));

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [\App\DataFixtures\TicketFixtures::class];
    }
}
