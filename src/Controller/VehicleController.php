<?php

namespace App\Controller;

use App\Entity\VehicleFeature;
use App\Repository\FeatureRepository;
use App\Repository\RentableVehicleRepository;
use App\Repository\VehicleFeatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VehicleController extends AbstractController
{
    #[Route('/vehicle/locations', name: 'app_vehicle_locations')]
    public function index(RentableVehicleRepository $rentableVehicleRepository): Response
    {
        $vehicles = $rentableVehicleRepository->findAll();

        return $this->render('vehicle/location/index.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    #[Route('/vehicle/locations/{id}', name: 'app_vehicle_locations_detail')]
    public function show(RentableVehicleRepository $rentableVehicleRepository, VehicleFeatureRepository $vehicleFeatureRepository, $id, FeatureRepository $featureRepository): Response
    {
        $vehicle = $rentableVehicleRepository->find($id);

        if (!$vehicle) {
            return $this->redirectToRoute('app_home');
        }

        $vehicleFeatures = $vehicleFeatureRepository->findBy(['vehicle' => $vehicle->getId()]);

        $features = array_map(fn(VehicleFeature $vf) => $vf->getFeature(), $vehicleFeatures);

        return $this->render('vehicle/location/detail.html.twig', [
            'vehicle' => $vehicle,
            'features' => $features,
        ]);
    }
}
