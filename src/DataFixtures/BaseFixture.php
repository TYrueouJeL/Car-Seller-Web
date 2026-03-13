<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixture extends Fixture
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    /**
     * @param class-string $className
     */
    protected function getRandomReference(string $prefix, int $count, string $className): object
    {
        return $this->getReference($prefix.$this->faker->numberBetween(0, $count - 1), $className);
    }
}
