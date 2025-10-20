<?php

namespace App\Controller;

use App\Entity\VehicleFeature;
use App\Repository\MaintenanceRepository;
use App\Repository\MaintenanceRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MaintenanceController extends AbstractController
{
    #[Route('/maintenance', name: 'app_maintenance')]
    public function index(MaintenanceRepository $maintenanceRepository, MaintenanceRequestRepository $maintenanceRequestRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_home');
        }

        $maintenances = $maintenanceRepository->findBy(['customer' => $user->getId()]);
        $maintenanceRequests = $maintenanceRequestRepository->findBy(['customer' => $user->getId()]);

        return $this->render('maintenance/index.html.twig', [
            'maintenances' => $maintenances,
            'maintenanceRequests' => $maintenanceRequests,
        ]);
    }
}
