<?php

namespace App\DataFixtures;

use App\Entity\MovementType;
use App\Entity\Piece;
use App\Entity\StockMovement;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StockMovementFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REF_PREFIX = 'stock_movement_';
    public const COUNT = 100;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $movement = new StockMovement();
            $movement->setQuantity($this->faker->numberBetween(1, 50));
            $movement->setMovementDate($this->faker->dateTimeBetween('-1 month', 'now'));
            $movement->setPiece($this->getRandomReference(PieceFixtures::REF_PREFIX, PieceFixtures::COUNT, Piece::class));
            $movement->setMovementType($this->getRandomReference(MovementTypeFixtures::REF_PREFIX, MovementTypeFixtures::COUNT, MovementType::class));

            $manager->persist($movement);
            $this->addReference(self::REF_PREFIX.$i, $movement);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PieceFixtures::class,
            MovementTypeFixtures::class,
        ];
    }
}
