<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\BookingRepository;
use App\Repository\TarificationRepository;

#[Route('/admin/bookings')]
class AdminBookingController extends AbstractController
{
    #[Route('/', name: 'app_admin_bookings')]
    public function index(BookingRepository $bookingRepository, TarificationRepository $tarificationRepository): Response   
     {
        $bookings = $bookingRepository->findAll();
        $tarifications = $tarificationRepository->findAll(); // ✅ Récupère toutes les tarifications
                foreach ($bookings as $booking) {
            $season = 'Basse';
            $month = (int)$booking->getDateStart()->format('m');

            if (in_array($month, [6, 7, 8])) {
                $season = 'Haute';
            } elseif (in_array($month, [4, 5, 9, 10])) {
                $season = 'Moyenne';
            }

            // Trouver la bonne tarification
            $tarification = array_filter($tarifications, function ($tarif) use ($season) {
                return $tarif->getSeason()->getName() === $season;
            });

            // Assigner la tarification au booking

            $booking->tarification = reset($tarification) ?: null;
        }

        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bookings,
            'tarifications' => $tarifications, // ✅ Transmet bien cette variable à Twig
        ]);
    }
}
