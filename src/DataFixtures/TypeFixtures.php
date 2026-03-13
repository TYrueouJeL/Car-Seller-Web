<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends BaseFixture
{
    public const REF_PREFIX = 'type_';
    public const COUNT = 10;

    public function load(ObjectManager $manager): void
    {
        $types = [
            ['name' => 'Revision complete', 'description' => 'Controle general, verification des fluides et reglages periodiques.', 'price' => '150.00', 'duration' => 30],
            ['name' => 'Vidange et filtres', 'description' => 'Remplacement de l huile moteur et des filtres.', 'price' => '80.00', 'duration' => 15],
            ['name' => 'Remplacement plaquettes de frein', 'description' => 'Remplacement des plaquettes et controle des disques.', 'price' => '220.00', 'duration' => 20],
            ['name' => 'Diagnostic electronique', 'description' => 'Scan electronique, lecture et suppression des codes defauts.', 'price' => '90.00', 'duration' => 10],
            ['name' => 'Courroie de distribution', 'description' => 'Remplacement de la courroie et controles associes.', 'price' => '450.00', 'duration' => 20],
            ['name' => 'Pneumatiques et equilibrage', 'description' => 'Remplacement des pneus, montage et equilibrage.', 'price' => '100.00', 'duration' => 15],
            ['name' => 'Remplacement batterie', 'description' => 'Test et remplacement de la batterie du vehicule.', 'price' => '130.00', 'duration' => 10],
            ['name' => 'Remplacement amortisseurs', 'description' => 'Remplacement des amortisseurs et geometrie si necessaire.', 'price' => '320.00', 'duration' => 20],
            ['name' => 'Entretien climatisation', 'description' => 'Rechargement gaz, controle des composants et desinfection.', 'price' => '140.00', 'duration' => 15],
            ['name' => 'Reparation echappement', 'description' => 'Remplacement ou soudure des elements du systeme d echappement.', 'price' => '200.00', 'duration' => 20],
        ];

        foreach ($types as $index => $data) {
            $type = new Type();
            $type->setName($data['name']);
            $type->setDescription($data['description']);
            $type->setPrice($data['price']);
            $type->setDuration($data['duration']);

            $manager->persist($type);
            $this->addReference(self::REF_PREFIX.$index, $type);
        }

        $manager->flush();
    }
}
