<?php
// php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\{Customer,
    Feature,
    Technician,
    Category,
    Type,
    Supplier,
    Piece,
    MovementType,
    MaintenanceStatus,
    Brand,
    Model,
    UserVehicle,
    RentableVehicle,
    SalableVehicle,
    Ticket,
    Maintenance,
    MaintenanceRequest,
    Feedback,
    Orders,
    RentalOrder,
    SaleOrder,
    StockMovement,
    SupplyOrder,
    SupplyOrderLine,
    TicketComment,
    VehicleFeature};

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // ==== CUSTOMERS ====
        $customers = [];
        for ($i = 0; $i < 40; $i++) {
            $c = new Customer();
            $c->setEmail($faker->unique()->email());
            $c->setFirstname($faker->firstName());
            $c->setLastname($faker->lastName());
            $hashed = $this->hasher->hashPassword($c, 'password123');
            $c->setPassword($hashed);
            $c->setRoles(['ROLE_CUSTOMER']);
            $manager->persist($c);
            $customers[] = $c;
        }

        // ==== TECHNICIANS ====
        $technicians = [];
        for ($i = 0; $i < 10; $i++) {
            $t = new Technician();
            $t->setEmail($faker->unique()->email());
            $t->setFirstname($faker->firstName());
            $t->setLastname($faker->lastName());
            $hashed = $this->hasher->hashPassword($t, 'password123');
            $t->setPassword($hashed);
            $t->setRoles(['ROLE_TECHNICIAN']);
            $manager->persist($t);
            $technicians[] = $t;
        }

        // ==== CATEGORIES ====
        $categories = [];
        $categoryNames = [
            'Citadine',
            'Berline',
            'Break',
            'SUV',
            'Monospace',
            'Coupé',
            'Cabriolet',
            'Utilitaire',
            'Compacte',
            'Hybride / Électrique'
        ];
        foreach ($categoryNames as $name) {
            $cat = new Category();
            $cat->setName($name);
            $manager->persist($cat);
            $categories[] = $cat;
        }

        // ==== TYPES ====
        $types = [];
        $serviceTypes = [
            ['name' => 'Révision complète', 'desc' => 'Contrôle général, vérification des fluides et réglages périodiques.', 'price' => 150, 'duration' => 30],
            ['name' => 'Vidange et filtres', 'desc' => 'Remplacement de l\'huile moteur et des filtres (huile/air/carburant).', 'price' => 80, 'duration' => 15],
            ['name' => 'Remplacement plaquettes de frein', 'desc' => 'Remplacement des plaquettes et contrôle des disques.', 'price' => 220, 'duration' => 20],
            ['name' => 'Diagnostic électronique', 'desc' => 'Scan électronique, lecture et suppression des codes défauts.', 'price' => 90, 'duration' => 10],
            ['name' => 'Courroie de distribution', 'desc' => 'Remplacement de la courroie et contrôles associés.', 'price' => 450, 'duration' => 20],
            ['name' => 'Pneumatiques et équilibrage', 'desc' => 'Remplacement des pneus, montage et équilibrage.', 'price' => 100, 'duration' => 15],
            ['name' => 'Remplacement batterie', 'desc' => 'Test et remplacement de la batterie du véhicule.', 'price' => 130, 'duration' => 10],
            ['name' => 'Remplacement amortisseurs', 'desc' => 'Remplacement des amortisseurs et géométrie si nécessaire.', 'price' => 320, 'duration' => 20],
            ['name' => 'Entretien climatisation', 'desc' => 'Rechargement gaz, contrôle des composants et désinfection.', 'price' => 140, 'duration' => 15],
            ['name' => 'Réparation échappement', 'desc' => 'Remplacement ou soudure des éléments du système d\'échappement.', 'price' => 200, 'duration' => 20],
        ];

        foreach ($serviceTypes as $st) {
            $type = new Type();
            $type->setName($st['name']);
            $type->setDescription($st['desc']);
            $type->setPrice($st['price']);
            $type->setDuration($st['duration']);
            $manager->persist($type);
            $types[] = $type;
        }

        // ==== MAINTENANCE STATUS ====
        $statuses = [];
        foreach (["En attente", "En cours", "Terminée"] as $s) {
            $status = new MaintenanceStatus();
            $status->setName($s);
            $manager->persist($status);
            $statuses[] = $status;
        }

        // ==== SUPPLIERS ====
        $suppliers = [];
        for ($i = 0; $i < 5; $i++) {
            $sup = new Supplier();
            $sup->setName($faker->company());
            $sup->setEmail($faker->companyEmail());
            $manager->persist($sup);
            $suppliers[] = $sup;
        }

        // ==== PIECES ====
        $pieces = [];
        $partNames = [
            "Filtre à huile", "Filtre à air", "Filtre à carburant", "Filtre d'habitacle",
            "Bougie d'allumage", "Plaquettes de frein", "Disque de frein", "Étrier de frein",
            "Amortisseur avant", "Amortisseur arrière", "Pneu 16\"", "Pneu 17\"", "Jante en alliage",
            "Alternateur", "Démarreur", "Radiateur", "Pompe à eau", "Courroie de distribution",
            "Courroie d'accessoire", "Pompe à carburant", "Injecteur", "Sonde lambda", "Catalyseur",
            "Silencieux", "Turbo", "Embrayage", "Volant moteur", "Boîte de vitesses", "Cardan",
            "Bras de suspension", "Rotule de direction", "Roulement de roue", "Support moteur",
            "Capteur ABS", "Capteur de température", "Capteur de pression", "Pare-brise",
            "Essuie-glace", "Phare avant", "Feu arrière", "Clignotant", "Pare-choc avant",
            "Pare-choc arrière", "Kit distribution", "Pompe à huile", "Condenseur de clim",
            "Compresseur de climatisation", "Boitier papillon", "Biellette de barre stabilisatrice",
            "Tuyau de radiateur", "Réservoir carburant", "Cable d'embrayage"
        ];

        $cheapKeywords = ['filtre', 'bougie', 'ampoule', 'joint', 'fusible', 'essuie-glace', 'biellette'];
        $midKeywords = ['plaquette', 'disque', 'pneu', 'amortisseur', 'radiateur', 'échappement', 'cardan', 'rotule'];
        $highKeywords = ['alternateur', 'démarreur', 'turbo', 'embrayage', 'moteur', 'boîte', 'injecteur', 'compresseur'];

        for ($i = 0; $i < 50; $i++) {
            $name = $faker->randomElement($partNames);
            $piece = new Piece();
            $piece->setName($name);

            // Déterminer une fourchette de prix réaliste selon le type de pièce
            $min = 20;
            $max = 200;
            $lowerName = mb_strtolower($name, 'UTF-8');

            foreach ($cheapKeywords as $kw) {
                if (mb_strpos($lowerName, $kw) !== false) {
                    $min = 5; $max = 80;
                    break;
                }
            }
            foreach ($midKeywords as $kw) {
                if (mb_strpos($lowerName, $kw) !== false) {
                    $min = 40; $max = 250;
                    break;
                }
            }
            foreach ($highKeywords as $kw) {
                if (mb_strpos($lowerName, $kw) !== false) {
                    $min = 200; $max = 2000;
                    break;
                }
            }

            $piece->setPrice($faker->randomFloat(2, $min, $max));
            $manager->persist($piece);
            $pieces[] = $piece;
        }

        // ==== MOVEMENT TYPE ====
        $movementTypes = [];
        foreach (["Entrée", "Sortie", "Inventaire"] as $m) {
            $mv = new MovementType();
            $mv->setName($m);
            $manager->persist($mv);
            $movementTypes[] = $mv;
        }

        // ==== BRANDS & MODELS REALISTES ====
        $brands = [];
        $models = [];

        $brandModels = [
            "Peugeot" => ["208", "308", "2008", "3008", "5008"],
            "Renault" => ["Clio", "Megane", "Captur", "Kadjar", "Talisman"],
            "Tesla"   => ["Model S", "Model 3", "Model X", "Model Y"],
            "BMW"     => ["Serie 1", "Serie 3", "Serie 5", "X1", "X5"],
            "Toyota"  => ["Yaris", "Corolla", "C-HR", "RAV4", "Prius"]
        ];

        foreach ($brandModels as $brandName => $modelNames) {
            $brand = new Brand();
            $brand->setName($brandName);
            $manager->persist($brand);
            $brands[] = $brand;

            foreach ($modelNames as $mName) {
                $model = new Model();
                $model->setName($mName);
                $model->setBrand($brand);
                $manager->persist($model);
                $models[] = $model;
            }
        }

        $features = [];
        foreach (["Airbag", "Fermeture centralisée", "ABS", "ESP", "Climatisation", "Radar de recul", "Caméra de recul", "Régulateur de vitesse", "Sièges chauffant"] as $f) {
            $feature = new Feature();
            $feature->setName($f);
            $manager->persist($feature);
            $features[] = $feature;
        }

        // Flush all basic entities first before creating relationships
        $manager->flush();

        // ==== VEHICLES: UserVehicle, RentableVehicle, SalableVehicle ====
        $userVehicles = [];
        for ($i = 0; $i < 100; $i++) {
            $uv = new UserVehicle();
            $uv->setModel($faker->randomElement($models));
            $uv->setCategory($faker->randomElement($categories));
            $uv->setCustomer($faker->randomElement($customers));
            $uv->setYear($faker->year());
            $uv->setMileage($faker->randomFloat(2, 0, 100000));
            $uv->setRegistration(strtoupper($faker->bothify('??-###-??')));
            $manager->persist($uv);
            $userVehicles[] = $uv;
        }

        $rentableVehicles = [];
        for ($i = 0; $i < 50; $i++) {
            $rv = new RentableVehicle();
            $rv->setModel($faker->randomElement($models));
            $rv->setCategory($faker->randomElement($categories));
            $rv->setDailyPrice($faker->randomFloat(2, 20, 200));
            $rv->setYear($faker->year());
            $rv->setMileage($faker->randomFloat(2, 0, 100000));
            $rv->setRegistration(strtoupper($faker->bothify('??-###-??')));
            $manager->persist($rv);
            $rentableVehicles[] = $rv;
        }

        $salableVehicles = [];
        for ($i = 0; $i < 50; $i++) {
            $sv = new SalableVehicle();
            $sv->setModel($faker->randomElement($models));
            $sv->setCategory($faker->randomElement($categories));
            $sv->setPrice($faker->randomFloat(2, 5000, 50000));
            $sv->setYear($faker->year());
            $sv->setMileage($faker->randomFloat(2, 0, 100000));
            $sv->setRegistration(strtoupper($faker->bothify('??-###-??')));
            $manager->persist($sv);
            $salableVehicles[] = $sv;
        }

        // Flush vehicles
        $manager->flush();

        // regrouper tous les véhicules pour usages génériques
        $allVehicles = array_merge($userVehicles, $rentableVehicles, $salableVehicles);

        // Assigner des features aléatoires (1..5) à chaque véhicule sans doublons
        foreach ($allVehicles as $veh) {
            $assigned = [];
            $nb = $faker->numberBetween(1, count($features));
            while (count($assigned) < $nb) {
                $feat = $faker->randomElement($features);
                if (in_array($feat, $assigned, true)) {
                    continue;
                }
                $assigned[] = $feat;
                $vf = new VehicleFeature();
                $vf->setVehicle($veh);
                $vf->setFeature($feat);
                $manager->persist($vf);
            }
        }

        // ==== MAINTENANCE REQUESTS (utiliser UserVehicle) ====
        $requests = [];
        for ($i = 0; $i < 20; $i++) {
            $req = new MaintenanceRequest();
            $req->setRequestDate($faker->dateTimeBetween('-1 month'));
            $req->setApprovedDate(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-10 days')));
            $req->setType($faker->randomElement($types));
            $req->setVehicle($faker->randomElement($userVehicles));
            $req->setTechnician($faker->randomElement($technicians));
            $req->setCustomer($faker->randomElement($customers));
            $manager->persist($req);
            $requests[] = $req;
        }

        // Flush maintenance requests
        $manager->flush();

        // ==== MAINTENANCES ====
        for ($i = 0; $i < 20; $i++) {
            $mnt = new Maintenance();
            $mnt->setDate($faker->dateTimeBetween('-1 month'));
            $mnt->setCustomer($faker->randomElement($customers));
            $mnt->setTechnician($faker->randomElement($technicians));
            $mnt->setMaintenanceStatus($faker->randomElement($statuses));
            $mnt->setMaintenanceRequest($faker->randomElement($requests));
            $mnt->setType($faker->randomElement($types));
            if (method_exists($mnt, 'setVehicle')) {
                $mnt->setVehicle($faker->randomElement($userVehicles));
            }
            $manager->persist($mnt);
        }

        // ==== TICKETS ====
        for ($i = 0; $i < 10; $i++) {
            $ticket = new Ticket();
            $ticket->setTitle($faker->sentence(3));
            $ticket->setDescription($faker->paragraph());
            $ticket->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 months')));
            $ticket->setTechnician($faker->randomElement($technicians));
            $ticket->setCustomer($faker->randomElement($customers));
            $manager->persist($ticket);
        }

        // ==== FEEDBACK ====
        for ($i = 0; $i < 25; $i++) {
            $fb = new Feedback();
            $fb->setRating($faker->numberBetween(1, 5));
            $fb->setComment($faker->sentence());
            $fb->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 month')));
            $fb->setVehicle($faker->randomElement($rentableVehicles));
            $fb->setCustomer($faker->randomElement($customers));
            $manager->persist($fb);
        }

        // ==== SALE ORDERS ====
        $saleOrders = [];
        for ($i = 0; $i < 20; $i++) {
            $so = new SaleOrder();
            $so->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 months')));
            $so->setCustomer($faker->randomElement($customers));
            $so->setVehicle($faker->randomElement($salableVehicles));
            $manager->persist($so);
            $saleOrders[] = $so;
        }

        // ==== RENTAL ORDERS ====
        $rentalOrders = [];
        for ($i = 0; $i < 20; $i++) {
            $ro = new RentalOrder();
            $ro->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 months')));
            $ro->setCustomer($faker->randomElement($customers));
            $ro->setVehicle($faker->randomElement($rentableVehicles));
            $startDate = $faker->dateTimeBetween('-1 month', '+1 month');
            $endDate = (clone $startDate)->modify('+'.$faker->numberBetween(1, 14).' days');
            $ro->setStartDate($startDate);
            $ro->setEndDate($endDate);
            $manager->persist($ro);
            $rentalOrders[] = $ro;
        }

        // ==== SUPPLY ORDERS ====
        $supplyOrders = [];
        for ($i = 0; $i < 10; $i++) {
            $so = new SupplyOrder();
            $so->setSupplier($faker->randomElement($suppliers));
            $manager->persist($so);
            $supplyOrders[] = $so;
        }

        // Flush orders
        $manager->flush();

        // ==== STOCK MOVEMENTS ====
        $movements = [];
        for ($i = 0; $i < 100; $i++) {
            $sm = new StockMovement();
            $sm->setQuantity($faker->numberBetween(1, 50));
            $sm->setMovementDate($faker->dateTimeBetween('-1 month'));
            $sm->setPiece($faker->randomElement($pieces));
            $sm->setMovementType($faker->randomElement($movementTypes));
            $manager->persist($sm);
            $movements[] = $sm;
        }

        // Flush stock movements
        $manager->flush();

        // ==== SUPPLY ORDER LINES ====
        for ($i = 0; $i < 200; $i++) {
            $sol = new SupplyOrderLine();
            $sol->setQuantity($faker->numberBetween(1, 50));
            $sol->setPiece($faker->randomElement($pieces));
            $sol->setStockMovement($faker->randomElement($movements));
            $sol->setSupplyOrder($faker->randomElement($supplyOrders));
            $manager->persist($sol);
        }

        // Final flush
        $manager->flush();
    }
}
