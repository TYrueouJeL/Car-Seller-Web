<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerFixtures extends BaseFixture
{
    public const REF_PREFIX = 'customer_';
    public const COUNT = 41;

    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 40; ++$i) {
            $customer = new Customer();
            $customer->setEmail($this->faker->unique()->safeEmail());
            $customer->setFirstname($this->faker->firstName());
            $customer->setLastname($this->faker->lastName());
            $customer->setPassword($this->hasher->hashPassword($customer, 'password123'));
            $customer->setRoles(['ROLE_CUSTOMER']);

            $manager->persist($customer);
            $this->addReference(self::REF_PREFIX.$i, $customer);
        }

        $seedCustomer = new Customer();
        $seedCustomer->setEmail('customer@customer.com');
        $seedCustomer->setFirstname('Customer');
        $seedCustomer->setLastname('Customer');
        $seedCustomer->setPassword($this->hasher->hashPassword($seedCustomer, 'password123'));
        $seedCustomer->setRoles(['ROLE_CUSTOMER']);

        $manager->persist($seedCustomer);
        $this->addReference(self::REF_PREFIX.'40', $seedCustomer);

        $manager->flush();
    }
}
