<?php

namespace App\DataFixtures;

use App\Entity\Piece;
use Doctrine\Persistence\ObjectManager;

class PieceFixtures extends BaseFixture
{
    public const REF_PREFIX = 'piece_';
    public const COUNT = 50;

    public function load(ObjectManager $manager): void
    {
        $partNames = [
            'Filtre a huile', 'Filtre a air', 'Filtre a carburant', 'Filtre d habitacle',
            'Bougie d allumage', 'Plaquettes de frein', 'Disque de frein', 'Etrier de frein',
            'Amortisseur avant', 'Amortisseur arriere', 'Pneu 16', 'Pneu 17', 'Jante en alliage',
            'Alternateur', 'Demarreur', 'Radiateur', 'Pompe a eau', 'Courroie de distribution',
            'Courroie d accessoire', 'Pompe a carburant', 'Injecteur', 'Sonde lambda', 'Catalyseur',
            'Silencieux', 'Turbo', 'Embrayage', 'Volant moteur', 'Boite de vitesses', 'Cardan',
            'Bras de suspension', 'Rotule de direction', 'Roulement de roue', 'Support moteur',
            'Capteur ABS', 'Capteur de temperature', 'Capteur de pression', 'Pare-brise',
            'Essuie-glace', 'Phare avant', 'Feu arriere', 'Clignotant', 'Pare-choc avant',
            'Pare-choc arriere', 'Kit distribution', 'Pompe a huile', 'Condenseur de clim',
            'Compresseur de climatisation', 'Boitier papillon', 'Biellette de barre stabilisatrice',
            'Tuyau de radiateur', 'Reservoir carburant',
        ];

        $cheapKeywords = ['filtre', 'bougie', 'ampoule', 'joint', 'fusible', 'essuie-glace', 'biellette'];
        $midKeywords = ['plaquette', 'disque', 'pneu', 'amortisseur', 'radiateur', 'echappement', 'cardan', 'rotule'];
        $highKeywords = ['alternateur', 'demarreur', 'turbo', 'embrayage', 'moteur', 'boite', 'injecteur', 'compresseur'];

        for ($i = 0; $i < self::COUNT; ++$i) {
            $name = $this->faker->randomElement($partNames);
            $priceRange = $this->resolvePriceRange($name, $cheapKeywords, $midKeywords, $highKeywords);

            $piece = new Piece();
            $piece->setName($name);
            $piece->setPrice((string) $this->faker->randomFloat(2, $priceRange['min'], $priceRange['max']));

            $manager->persist($piece);
            $this->addReference(self::REF_PREFIX.$i, $piece);
        }

        $manager->flush();
    }

    /**
     * @return array{min:int,max:int}
     */
    private function resolvePriceRange(string $name, array $cheapKeywords, array $midKeywords, array $highKeywords): array
    {
        $name = strtolower($name);
        $range = ['min' => 20, 'max' => 200];

        foreach ($cheapKeywords as $keyword) {
            if (str_contains($name, $keyword)) {
                return ['min' => 5, 'max' => 80];
            }
        }

        foreach ($midKeywords as $keyword) {
            if (str_contains($name, $keyword)) {
                return ['min' => 40, 'max' => 250];
            }
        }

        foreach ($highKeywords as $keyword) {
            if (str_contains($name, $keyword)) {
                return ['min' => 200, 'max' => 2000];
            }
        }

        return $range;
    }
}
