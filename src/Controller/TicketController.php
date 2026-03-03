<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\TicketComment;
use App\Form\TicketCommentFormType;
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

    #[Route('/ticket/comment/{id}/delete', name: 'app_ticket_comment_delete')]
    public function deleteComment(TicketCommentRepository $ticketCommentRepository, $id, Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $ticketComment = $ticketCommentRepository->find($id);

        if (!$user || $user != $ticketComment->getAuthor()) {
            return $this->redirectToRoute('app_home');
        }

        if ($ticketComment->getTicket()->getStatus()->getName() == 'Résolu') {
            return $this->redirectToRoute('app_ticket_detail', ['id' => $ticketComment->getTicket()->getId()]);
        }

        $manager->remove($ticketComment);
        $manager->flush();

        return $this->redirectToRoute('app_ticket_detail', ['id' => $ticketComment->getTicket()->getId()]);
    }

    #[Route('/ticket/{id}', name: 'app_ticket_detail')]
    public function detail(TicketRepository $ticketRepository, $id, TicketCommentRepository $ticketCommentRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();

        $ticket = $ticketRepository->find($id);

        $ticketComments = $ticketCommentRepository->findBy(['ticket' => $ticket->getId()], ['createdAt' => 'DESC']);

        if (!$user || $user != $ticket->getCustomer()) {
            return $this->redirectToRoute('app_home');
        }

        $ticketComment = new TicketComment();

        $form = $this->createForm(TicketCommentFormType::class, $ticketComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticketComment = $form->getData();
            $ticketComment->setTicket($ticket);
            $ticketComment->setAuthor($user);
            $ticketComment->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($ticketComment);
            $manager->flush();

            $ticketComments = $ticketCommentRepository->findBy(['ticket' => $ticket->getId()], ['createdAt' => 'DESC']);
            $ticketComment = new TicketComment();
            $form = $this->createForm(TicketCommentFormType::class, $ticketComment);
        }

        return $this->render('ticket/detail.html.twig', [
            'ticket' => $ticket,
            'ticketComments' => $ticketComments,
            'form' => $form,
        ]);
    }
}
