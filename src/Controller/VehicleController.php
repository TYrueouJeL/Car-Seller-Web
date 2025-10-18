<?php

namespace App\Controller;

use App\Entity\VehicleFeature;
use App\Repository\FeatureRepository;
use App\Repository\RentableVehicleRepository;
use App\Repository\SalableVehicleRepository;
use App\Repository\VehicleFeatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VehicleController extends AbstractController
{
    #[Route('/vehicle/rental', name: 'app_vehicle_rental')]
    public function index(RentableVehicleRepository $rentableVehicleRepository): Response
    {
        $vehicles = $rentableVehicleRepository->findAll();

        return $this->render('vehicle/rental/index.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    #[Route('/vehicle/rental/{id}', name: 'app_vehicle_rental_detail')]
    public function show(RentableVehicleRepository $rentableVehicleRepository, VehicleFeatureRepository $vehicleFeatureRepository, $id, FeatureRepository $featureRepository): Response
    {
        $vehicle = $rentableVehicleRepository->find($id);

        if (!$vehicle) {
            return $this->redirectToRoute('app_home');
        }

        $vehicleFeatures = $vehicleFeatureRepository->findBy(['vehicle' => $vehicle->getId()]);

        $features = array_map(fn(VehicleFeature $vf) => $vf->getFeature(), $vehicleFeatures);

        return $this->render('vehicle/rental/detail.html.twig', [
            'vehicle' => $vehicle,
            'features' => $features,
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
}
