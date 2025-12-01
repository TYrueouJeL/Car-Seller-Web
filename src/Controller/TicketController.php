<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'app_ticket')]
    public function index(TicketRepository $ticketRepository): Response
    {
        $tickets = $ticketRepository->findBy(['customer' => $this->getUser()], ['createdAt' => 'DESC']);

        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }
}
