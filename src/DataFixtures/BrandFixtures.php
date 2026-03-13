<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends BaseFixture
{
    public const REF_PREFIX = 'brand_';
    public const COUNT = 5;

    public const BRAND_MODELS = [
        'Peugeot' => ['208', '308', '2008', '3008', '5008'],
        'Renault' => ['Clio', 'Megane', 'Captur', 'Kadjar', 'Talisman'],
        'Tesla' => ['Model S', 'Model 3', 'Model X', 'Model Y'],
        'BMW' => ['Serie 1', 'Serie 3', 'Serie 5', 'X1', 'X5'],
        'Toyota' => ['Yaris', 'Corolla', 'C-HR', 'RAV4', 'Prius'],
    ];

    public function load(ObjectManager $manager): void
    {
        $index = 0;
        foreach (array_keys(self::BRAND_MODELS) as $brandName) {
            $brand = new Brand();
            $brand->setName($brandName);

            $manager->persist($brand);
            $this->addReference(self::REF_PREFIX.$index, $brand);
            ++$index;
        }

        $manager->flush();
    }
}
