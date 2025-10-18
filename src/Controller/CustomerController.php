<?php

namespace App\Controller;

use App\Repository\RentableVehicleRepository;
use App\Repository\RentalOrderRepository;
use App\Repository\SalableVehicleRepository;
use App\Repository\UserVehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CustomerController extends AbstractController
{
    #[Route('/customer', name: 'app_customer')]
    public function index(UserVehicleRepository $userVehicleRepository, RentableVehicleRepository $rentableVehicleRepository, RentalOrderRepository $rentalOrderRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $userVehicles = $userVehicleRepository->findBy(['customer' => $user->getId()]);

        $rentalOrders = $rentalOrderRepository->findBy(['customer' => $user->getId()]);
        $rentalOrders = array_map(fn($order) => $order->getVehicle(), $rentalOrders);

        $rentalVehicles = $rentableVehicleRepository->findBy(['id' => $rentalOrders]);

        return $this->render('customer/index.html.twig', [
            'user' => $user,
            'userVehicles' => $userVehicles,
            'rentalVehicles' => $rentalVehicles,
        ]);
    }
}
