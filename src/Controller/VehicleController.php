<?php

namespace App\Controller;

use App\Entity\MaintenanceRequest;
use App\Entity\RentalOrder;
use App\Entity\UserVehicle;
use App\Entity\VehicleFeature;
use App\Form\MaintenanceRequestFormType;
use App\Form\RentalOrderFormType;
use App\Repository\RentableVehicleRepository;
use App\Repository\RentalOrderRepository;
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
        $vehicles = $rentableVehicleRepository->findAllWithDetails();

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

        if ($request->isMethod('POST')) {

            $period = $request->request->get('rental_period');

            if (!$period || strpos($period, ' to ') === false) {
                $this->addFlash('error', 'Veuillez sélectionner une période valide.');
                return $this->redirectToRoute('app_vehicle_rental_detail', ['id' => $id]);
            }

            [$startDate, $endDate] = explode(' to ', $period);
            $startDate = new \DateTime($startDate);
            $endDate = new \DateTime($endDate);

            $rentalOrder = new RentalOrder();
            $rentalOrder->setCustomer($this->getUser());
            $rentalOrder->setVehicle($vehicle);
            $rentalOrder->setStartDate($startDate);
            $rentalOrder->setEndDate($endDate);
            $rentalOrder->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($rentalOrder);
            $entityManager->flush();
            $this->addFlash('success', 'Réservation enregistrée');
        }

        $unavailableDates = $rentableVehicleRepository->findUnavailableDates($vehicle);

        return $this->render('vehicle/rental/detail.html.twig', [
            'vehicle' => $vehicle,
            'features' => $features,
            'unavailableDates' => $unavailableDates,
        ]);
    }

    #[Route('/vehicle/sale', name: 'app_vehicle_sale')]
    public function sales(SalableVehicleRepository $salableVehicleRepository): Response
    {
        $vehicles = $salableVehicleRepository->findAllWithDetails();

        return $this->render('vehicle/sales/index.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    #[Route('/vehicle/sale/{id}', name: 'app_vehicle_sale_detail')]
    public function saleDetail(SalableVehicleRepository $salableVehicleRepository, $id, VehicleFeatureRepository $vehicleFeatureRepository, Request $request, EntityManagerInterface $entityManager, RentalOrderRepository $rentalOrderRepository): Response
    {
        $vehicle = $salableVehicleRepository->find($id);

        if (!$vehicle) {
            return $this->redirectToRoute('app_home');
        }

        $vehicleFeatures = $vehicleFeatureRepository->findBy(['vehicle' => $vehicle->getId()]);

        $features = array_map(fn(VehicleFeature $vf) => $vf->getFeature(), $vehicleFeatures);

        if ($request->isMethod('POST') && $request->request->get('action') === 'buy') {
            $userVehicle = new UserVehicle();

            $userVehicle->setCustomer($this->getUser());
            $userVehicle->setCategory($vehicle->getCategory());
            $userVehicle->setModel($vehicle->getModel());
            $userVehicle->setRegistration($vehicle->getRegistration());
            $userVehicle->setYear($vehicle->getYear());
            $userVehicle->setMileage($vehicle->getMileage());

            $entityManager->persist($userVehicle);

            foreach ($vehicleFeatures as $vehicleFeature) {
                $vehicleFeature->setVehicle($userVehicle);
                $entityManager->persist($vehicleFeature);
            }

            $entityManager->remove($vehicle);
            $entityManager->flush();

            return $this->redirectToRoute('app_customer');
        }

        return $this->render('vehicle/sales/detail.html.twig', [
            'vehicle' => $vehicle,
            'features' => $features,
        ]);
    }

    #[Route('/vehicle/userVehicle/{id}', name: 'app_vehicle_userVehicle')]
    public function userVehicleDetail($id,EntityManagerInterface $entityManager, Request $request, UserVehicleRepository $userVehicleRepository, VehicleFeatureRepository $vehicleFeatureRepository): Response
    {
        $vehicle = $userVehicleRepository->find($id);
        $user = $this->getUser();

        if (!$vehicle) {
            return $this->redirectToRoute('app_home');
        }
        if ($vehicle->getCustomer() !== $user) {
            return $this->redirectToRoute('app_home');
        }

        $vehicleFeatures = $vehicleFeatureRepository->findBy(['vehicle' => $vehicle->getId()]);

        $features = array_map(fn(VehicleFeature $vf) => $vf->getFeature(), $vehicleFeatures);

        $maintenanceRequestForm = $this->createForm(MaintenanceRequestFormType::class);
        $maintenanceRequestForm->handleRequest($request);

        if ($maintenanceRequestForm->isSubmitted() && $maintenanceRequestForm->isValid()) {
            $maintenanceRequest = new MaintenanceRequest();

            $maintenanceRequest->setCustomer($this->getUser());
            $maintenanceRequest->setVehicle($vehicle);

            $requestDate = $maintenanceRequestForm->get('requestDate')->getData();

            if ($requestDate < new \DateTime()) {
                $this->addFlash('error', 'La date ne peut pas être dans le passé');
            } else {
                $maintenanceRequest->setRequestDate($requestDate);
                $maintenanceRequest->setType($maintenanceRequestForm->get('type')->getData());

                $entityManager->persist($maintenanceRequest);
                $entityManager->flush();

                $this->addFlash('success', 'La demande de rendez-vous à été créée.');

                return $this->redirectToRoute('app_vehicle_userVehicle', ['id' => $vehicle->getId()]);
            }
        }

        return $this->render('vehicle/userVehicle/detail.html.twig', [
            'vehicle' => $vehicle,
            'features' => $features,
            'maintenanceRequestForm' => $maintenanceRequestForm,
        ]);
    }
}
