<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Accomodation;
use App\Form\BookingType;
use App\Repository\TarificationRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/booking')]
final class BookingController extends AbstractController
{
    #[Route(name: 'app_booking_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository, TarificationRepository $tarificationRepository): Response
    {
        $bookings = $bookingRepository->findAll();
        $tarifications =$tarificationRepository->findAll();

        return $this->render('/booking/index.html.twig', [
            'bookings' => $bookings,
            'tarifications' => $tarifications, // Maintenant sous forme de Collection
        ]);
    }

    #[Route('/new', name: 'app_booking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_show', methods: ['GET'])]
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_booking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_delete', methods: ['POST'])]
    public function delete(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/booking/clossing/{id}', name: 'app_booking_clossing', methods: ['GET', 'POST'])]
    public function clossing(int $id, Request $request): Response
    {
        // Implémente la logique pour réserver (par exemple, marquer la réservation comme validée)
        
        return $this->redirectToRoute('app_booking_index');
    }
    #[Route('/booking/reserver/{id}', name: 'app_booking_reserver', methods: ['GET', 'POST'])]
    public function reserver(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifie si la réservation existe ou crée une nouvelle
        $booking = new Booking();
        
        // Récupérer l'utilisateur connecté
        $user = $this->getUser(); // Assure-toi que l'utilisateur est bien connecté
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour réserver.');
        }

        // Récupérer l'hébergement associé
        $accomodation = $entityManager->getRepository(Accomodation::class)->find($id);
        if (!$accomodation) {
            throw $this->createNotFoundException('Hébergement introuvable.');
        }

        // Associer l'utilisateur et l'hébergement à la réservation
        $booking->setUsers($user);
        $booking->setAccomodation($accomodation);

        // Création du formulaire
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                        // Sauvegarde de la réservation
            $entityManager->persist($booking);
            $entityManager->flush();

            $this->addFlash('success', 'Réservation effectuée avec succès !');

            return $this->redirectToRoute('app_booking_index');
        }

        // Affichage du formulaire
        return $this->render('booking/reserver.html.twig', [
            'form' => $form->createView(),
            'accomodation' => $accomodation,
        ]);
    }
}
