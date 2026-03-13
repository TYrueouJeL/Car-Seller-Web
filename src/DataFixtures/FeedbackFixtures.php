<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Feedback;
use App\Entity\RentableVehicle;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FeedbackFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const COUNT = 25;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $feedback = new Feedback();
            $feedback->setRating($this->faker->numberBetween(1, 5));
            $feedback->setComment($this->faker->sentence(10));
            $feedback->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-2 months', 'now')));
            $feedback->setVehicle($this->getRandomReference(RentableVehicleFixtures::REF_PREFIX, RentableVehicleFixtures::COUNT, RentableVehicle::class));
            $feedback->setCustomer($this->getRandomReference(CustomerFixtures::REF_PREFIX, CustomerFixtures::COUNT, Customer::class));

            $manager->persist($feedback);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RentableVehicleFixtures::class,
            CustomerFixtures::class,
        ];
    }
}
