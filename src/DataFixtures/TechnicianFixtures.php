<?php

namespace App\DataFixtures;

use App\Entity\Technician;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TechnicianFixtures extends BaseFixture
{
    public const REF_PREFIX = 'technician_';
    public const COUNT = 11;

    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        $roles = ['ROLE_TECHNICIAN', 'ROLE_MANAGER', 'ROLE_ADMIN'];

        for ($i = 0; $i < 10; ++$i) {
            $technician = new Technician();
            $technician->setEmail($this->faker->unique()->safeEmail());
            $technician->setFirstname($this->faker->firstName());
            $technician->setLastname($this->faker->lastName());
            $technician->setPassword($this->hasher->hashPassword($technician, 'password123'));
            $technician->setRoles([$this->faker->randomElement($roles)]);
            $technician->setPhoneNumber($this->faker->numerify('0#########'));

            $manager->persist($technician);
            $this->addReference(self::REF_PREFIX.$i, $technician);
        }

        $admin = new Technician();
        $admin->setEmail('remig@remig.com');
        $admin->setFirstname('Remi');
        $admin->setLastname('Guerin');
        $admin->setPassword($this->hasher->hashPassword($admin, 'password123'));
        $admin->setRoles(['ROLE_TECHNICIAN', 'ROLE_MANAGER', 'ROLE_ADMIN']);
        $admin->setPhoneNumber($this->faker->numerify('0#########'));

        $manager->persist($admin);
        $this->addReference(self::REF_PREFIX.'10', $admin);

        $manager->flush();
    }
}
