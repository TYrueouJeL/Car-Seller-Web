<?php

namespace App\DataFixtures;

use App\Entity\Piece;
use App\Entity\StockMovement;
use App\Entity\SupplyOrder;
use App\Entity\SupplyOrderLine;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SupplyOrderLineFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const COUNT = 200;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; ++$i) {
            $line = new SupplyOrderLine();
            $line->setQuantity($this->faker->numberBetween(1, 50));
            $line->setPiece($this->getRandomReference(\App\DataFixtures\PieceFixtures::REF_PREFIX, \App\DataFixtures\PieceFixtures::COUNT, Piece::class));
            $line->setStockMovement($this->getRandomReference(\App\DataFixtures\StockMovementFixtures::REF_PREFIX, \App\DataFixtures\StockMovementFixtures::COUNT, StockMovement::class));
            $line->setSupplyOrder($this->getRandomReference(\App\DataFixtures\SupplyOrderFixtures::REF_PREFIX, \App\DataFixtures\SupplyOrderFixtures::COUNT, SupplyOrder::class));

            $manager->persist($line);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            \App\DataFixtures\PieceFixtures::class,
            \App\DataFixtures\StockMovementFixtures::class,
            \App\DataFixtures\SupplyOrderFixtures::class,
        ];
    }
}
