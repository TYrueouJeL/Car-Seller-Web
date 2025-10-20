<?php

namespace App\Controller;

use App\Entity\RentalOrder;
use App\Entity\VehicleFeature;
use App\Form\RentalOrderFormType;
use App\Repository\RentableVehicleRepository;
use App\Repository\SalableVehicleRepository;
use App\Repository\UserVehicleRepository;
use App\Repository\VehicleFeatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VehicleController extends AbstractController
{
    #[Route('/vehicle/rental', name: 'app_vehicle_rental')]
    public function rentals(RentableVehicleRepository $rentableVehicleRepository): Response
    {
        $vehicles = $rentableVehicleRepository->findAll();

        return $this->render('vehicle/rental/index.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    #[Route('/vehicle/rental/{id}', name: 'app_vehicle_rental_detail')]
    public function rentalDetail(RentableVehicleRepository $rentableVehicleRepository, VehicleFeatureRepository $vehicleFeatureRepository, $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $vehicle = $rentableVehicleRepository->find($id);

        if (!$vehicle) {
            return $this->redirectToRoute('app_home');
        }

        $vehicleFeatures = $vehicleFeatureRepository->findBy(['vehicle' => $vehicle->getId()]);

        $features = array_map(fn(VehicleFeature $vf) => $vf->getFeature(), $vehicleFeatures);

        $rentalOrderForm = $this->createForm(RentalOrderFormType::class);
        $rentalOrderForm->handleRequest($request);

        if ($rentalOrderForm->isSubmitted() && $rentalOrderForm->isValid()) {
            $rentalOrder = new RentalOrder();

            $rentalOrder->setCustomer($this->getUser());
            $rentalOrder->setVehicle($vehicle);
            $rentalOrder->setCreatedAt(new \DateTimeImmutable());

            $startDate = $rentalOrderForm->get('startDate')->getData();
            $endDate = $rentalOrderForm->get('endDate')->getData();

            if ($startDate > $endDate) {
                $this->addFlash('error', 'La date de fin ne peut pas être postérieure à la date de début.');
            } else {
                $rentalOrder->setStartDate($rentalOrderForm->get('startDate')->getData());
                $rentalOrder->setEndDate($rentalOrderForm->get('endDate')->getData());;

                $entityManager->persist($rentalOrder);
                $entityManager->flush();

                $this->addFlash('success', 'Réservation créée.');

                return $this->redirectToRoute('app_vehicle_rental_detail', ['id' => $vehicle->getId()]);
            }
        }

        return $this->render('vehicle/rental/detail.html.twig', [
            'vehicle' => $vehicle,
            'features' => $features,
            'rentalOrderForm' => $rentalOrderForm,
        ]);
    }

    #[Route('/vehicle/sale', name: 'app_vehicle_sale')]
    public function sales(SalableVehicleRepository $salableVehicleRepository): Response
    {
        $vehicles = $salableVehicleRepository->findAll();

        return $this->render('vehicle/sales/index.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    #[Route('/vehicle/sale/{id}', name: 'app_vehicle_sale_detail')]
    public function saleDetail(SalableVehicleRepository $salableVehicleRepository, $id, VehicleFeatureRepository $vehicleFeatureRepository): Response
    {
        $vehicle = $salableVehicleRepository->find($id);

        if (!$vehicle) {
            return $this->redirectToRoute('app_home');
        }

        $vehicleFeatures = $vehicleFeatureRepository->findBy(['vehicle' => $vehicle->getId()]);

        $features = array_map(fn(VehicleFeature $vf) => $vf->getFeature(), $vehicleFeatures);

        return $this->render('vehicle/sales/detail.html.twig', [
            'vehicle' => $vehicle,
            'features' => $features,
        ]);
    }

    #[Route('/vehicle/userVehicle/{id}', name: 'app_vehicle_userVehicle')]
    public function userVehicleDetail($id, UserVehicleRepository $userVehicleRepository, VehicleFeatureRepository $vehicleFeatureRepository): Response
    {
        $vehicle = $userVehicleRepository->find($id);

        if (!$vehicle) {
            return $this->redirectToRoute('app_home');
        }

        $vehicleFeatures = $vehicleFeatureRepository->findBy(['vehicle' => $vehicle->getId()]);

        $features = array_map(fn(VehicleFeature $vf) => $vf->getFeature(), $vehicleFeatures);

        return $this->render('vehicle/userVehicle/detail.html.twig', [
            'vehicle' => $vehicle,
            'features' => $features,
        ]);
    }
}
