<?php

namespace App\DataFixtures;

use App\Entity\MovementType;
use Doctrine\Persistence\ObjectManager;

class MovementTypeFixtures extends BaseFixture
{
    public const REF_PREFIX = 'movement_type_';
    public const COUNT = 3;

    public function load(ObjectManager $manager): void
    {
        foreach (['Entree', 'Sortie', 'Inventaire'] as $index => $name) {
            $movementType = new MovementType();
            $movementType->setName($name);

            $manager->persist($movementType);
            $this->addReference(self::REF_PREFIX.$index, $movementType);
        }

        $manager->flush();
    }
}
