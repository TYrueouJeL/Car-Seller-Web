<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketFormType;
use App\Repository\TicketCommentRepository;
use App\Repository\TicketRepository;
use App\Repository\TicketStatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'app_ticket')]
    public function index(TicketRepository $ticketRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_home');
        }

        $tickets = $ticketRepository->findBy(['customer' => $this->getUser()], ['createdAt' => 'DESC']);

        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    #[Route('/ticket/new', name: 'app_ticket_new')]
    public function new(Request $request, TicketStatusRepository $ticketStatusRepository, EntityManagerInterface $manager): Response
    {
        $ticket = new Ticket();
        $ticketStatus = $ticketStatusRepository->findOneBy(['name' => 'Déclaré']);

        $form = $this->createForm(TicketFormType::class, $ticket);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ticket = $form->getData();
            $ticket->setCustomer($this->getUser());
            $ticket->setCreatedAt(new \DateTimeImmutable());
            $ticket->setStatus($ticketStatus);
            $manager->persist($ticket);
            $manager->flush();

            return $this->redirectToRoute('app_ticket');
        }

        return $this->render('ticket/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/ticket/{id}', name: 'app_ticket_detail')]
    public function detail(TicketRepository $ticketRepository, $id, TicketCommentRepository $ticketCommentRepository): Response
    {
        $user = $this->getUser();

        $ticket = $ticketRepository->find($id);

        $ticketComments = $ticketCommentRepository->findBy(['ticket' => $ticket->getId()], ['createdAt' => 'DESC']);

        if (!$user || $user != $ticket->getCustomer()) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('ticket/detail.html.twig', [
            'ticket' => $ticket,
            'ticketComments' => $ticketComments,
        ]);
    }
}
