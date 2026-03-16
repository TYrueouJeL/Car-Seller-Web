<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerFormType;
use App\Repository\RentalOrderRepository;
use App\Repository\UserVehicleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CustomerController extends AbstractController
{
    #[Route('/customer', name: 'app_customer')]
    public function index(UserVehicleRepository $userVehicleRepository, RentalOrderRepository $rentalOrderRepository): Response
    {
        $user = $this->getUser();

        if (!$user instanceof Customer) {
            return $this->redirectToRoute('app_login');
        }

        $userVehicles = $userVehicleRepository->findBy(['customer' => $user]);

        $today = (new DateTime())->setTime(0, 0, 0);
        $rentalOrders = $rentalOrderRepository->findBy(['customer' => $user]);
        $activeOrders = array_filter(
            $rentalOrders,
            fn($order) => $order->getStartDate() <= $today && $order->getEndDate() >= $today
        );
        $upcomingOrders = array_filter(
            $rentalOrders,
            fn($order) => $order->getStartDate() > $today
        );

        $rentalVehiclesById = [];
        foreach ($activeOrders as $order) {
            $vehicle = $order->getVehicle();
            if ($vehicle === null || $vehicle->getId() === null) {
                continue;
            }
            $rentalVehiclesById[$vehicle->getId()] = $vehicle;
        }
        $rentalVehicles = array_values($rentalVehiclesById);

        $upcomingRentalVehiclesById = [];
        foreach ($upcomingOrders as $order) {
            $vehicle = $order->getVehicle();
            if ($vehicle === null || $vehicle->getId() === null) {
                continue;
            }
            $upcomingRentalVehiclesById[$vehicle->getId()] = $vehicle;
        }
        $upcomingRentalVehicles = array_values($upcomingRentalVehiclesById);

        return $this->render('customer/index.html.twig', [
            'user' => $user,
            'userVehicles' => $userVehicles,
            'rentalVehicles' => $rentalVehicles,
            'upcomingRentalVehicles' => $upcomingRentalVehicles,
        ]);
    }

    #[Route('/customer/modify', name: 'app_customer_modify')]
    public function modify(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(CustomerFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Vos informations ont été mises à jour avec succès.');

            return $this->redirectToRoute('app_customer');
        }

        return $this->render('customer/modify.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
