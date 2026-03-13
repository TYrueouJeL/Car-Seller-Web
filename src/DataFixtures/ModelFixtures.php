<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Model;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModelFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const REF_PREFIX = 'model_';
    public const COUNT = 24;

    public function load(ObjectManager $manager): void
    {
        $modelIndex = 0;
        foreach (array_values(\App\DataFixtures\BrandFixtures::BRAND_MODELS) as $brandIndex => $models) {
            $brand = $this->getReference(\App\DataFixtures\BrandFixtures::REF_PREFIX.$brandIndex, Brand::class);
            foreach ($models as $modelName) {
                $model = new Model();
                $model->setName($modelName);
                $model->setBrand($brand);
                $model->setCategory($this->getRandomReference(CategoryFixtures::REF_PREFIX, CategoryFixtures::COUNT, Category::class));

                $manager->persist($model);
                $this->addReference(self::REF_PREFIX.$modelIndex, $model);
                ++$modelIndex;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BrandFixtures::class,
            CategoryFixtures::class,
];
    }
}
