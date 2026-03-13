<?php

namespace App\DataFixtures;

use App\Entity\Feature;
use Doctrine\Persistence\ObjectManager;

class FeatureFixtures extends BaseFixture
{
    public const REF_PREFIX = 'feature_';
    public const COUNT = 9;

    public function load(ObjectManager $manager): void
    {
        $features = [
            'Airbag',
            'Fermeture centralisee',
            'ABS',
            'ESP',
            'Climatisation',
            'Radar de recul',
            'Camera de recul',
            'Regulateur de vitesse',
            'Sieges chauffants',
        ];

        foreach ($features as $index => $name) {
            $feature = new Feature();
            $feature->setName($name);

            $manager->persist($feature);
            $this->addReference(self::REF_PREFIX.$index, $feature);
        }

        $manager->flush();
    }
}
