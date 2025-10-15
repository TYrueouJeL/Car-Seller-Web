<?php
// php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\{
    Customer,
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
    TicketComment
};

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
            $manager->persist($t);
            $technicians[] = $t;
        }

        // ==== CATEGORIES ====
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $cat = new Category();
            $cat->setName($faker->word());
            $manager->persist($cat);
            $categories[] = $cat;
        }

        // ==== TYPES ====
        $types = [];
        for ($i = 0; $i < 5; $i++) {
            $type = new Type();
            $type->setName($faker->word());
            $type->setDescription($faker->sentence());
            $type->setPrice($faker->numberBetween(50, 500));
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
        for ($i = 0; $i < 50; $i++) {
            $piece = new Piece();
            $piece->setName($faker->word());
            $piece->setPrice($faker->randomFloat(2, 10, 100));
            $manager->persist($piece);
            $pieces[] = $piece;
        }

        // ==== MOVEMENT TYPE ====
        $movementTypes = [];
        foreach (["Entrée", "Sortie", "Ajustement"] as $m) {
            $mv = new MovementType();
            $mv->setName($m);
            $manager->persist($mv);
            $movementTypes[] = $mv;
        }

        // ==== BRAND ====
        $brands = [];
        foreach (["Peugeot", "Renault", "Tesla", "BMW", "Toyota"] as $b) {
            $brand = new Brand();
            $brand->setName($b);
            $manager->persist($brand);
            $brands[] = $brand;
        }

        // ==== MODELS ====
        $models = [];
        for ($i = 0; $i < 20; $i++) {
            $model = new Model();
            $model->setName($faker->word());
            $model->setBrand($faker->randomElement($brands));
            $manager->persist($model);
            $models[] = $model;
        }

        // Flush all basic entities first before creating relationships
        $manager->flush();

        // ==== VEHICLES: UserVehicle, RentableVehicle, SalableVehicle ====
        $userVehicles = [];
        for ($i = 0; $i < 100; $i++) {
            $uv = new UserVehicle();
            $uv->setModel($faker->randomElement($models));
            $uv->setCategory($faker->randomElement($categories));
            if (method_exists($uv, 'setOwner')) {
                $uv->setOwner($faker->randomElement($customers));
            } elseif (method_exists($uv, 'setCustomer')) {
                $uv->setCustomer($faker->randomElement($customers));
            }
            $manager->persist($uv);
            $userVehicles[] = $uv;
        }

        $rentableVehicles = [];
        for ($i = 0; $i < 50; $i++) {
            $rv = new RentableVehicle();
            $rv->setModel($faker->randomElement($models));
            $rv->setCategory($faker->randomElement($categories));
            if (method_exists($rv, 'setDailyRate')) {
                $rv->setDailyRate($faker->randomFloat(2, 20, 200));
            } elseif (method_exists($rv, 'setRentPrice')) {
                $rv->setRentPrice($faker->randomFloat(2, 20, 200));
            }
            $manager->persist($rv);
            $rentableVehicles[] = $rv;
        }

        $salableVehicles = [];
        for ($i = 0; $i < 50; $i++) {
            $sv = new SalableVehicle();
            $sv->setModel($faker->randomElement($models));
            $sv->setCategory($faker->randomElement($categories));
            if (method_exists($sv, 'setPrice')) {
                $sv->setPrice($faker->randomFloat(2, 5000, 50000));
            }
            $manager->persist($sv);
            $salableVehicles[] = $sv;
        }

        // Flush vehicles
        $manager->flush();

        // regrouper tous les véhicules pour usages génériques
        $allVehicles = array_merge($userVehicles, $rentableVehicles, $salableVehicles);

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
            $mnt->setIsDone($faker->boolean());
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
