<?php

namespace App\Controller;

use App\Repository\RentableVehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VehicleController extends AbstractController
{
    #[Route('/vehicle/locations', name: 'app_vehicle_locations')]
    public function index(RentableVehicleRepository $rentableVehicleRepository): Response
    {
        $vehicles = $rentableVehicleRepository->findAll();

        return $this->render('vehicle/index.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }
}
