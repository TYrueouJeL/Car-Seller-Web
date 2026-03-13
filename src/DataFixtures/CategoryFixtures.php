<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends BaseFixture
{
    public const REF_PREFIX = 'category_';
    public const COUNT = 10;

    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Citadine',
            'Berline',
            'Break',
            'SUV',
            'Monospace',
            'Coupe',
            'Cabriolet',
            'Utilitaire',
            'Compacte',
            'Hybride / Electrique',
        ];

        foreach ($categories as $index => $name) {
            $category = new Category();
            $category->setName($name);

            $manager->persist($category);
            $this->addReference(self::REF_PREFIX.$index, $category);
        }

        $manager->flush();
    }
}
