<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\AccomodationRepository;
use App\Repository\TarificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        BookingRepository $bookingRepository, 
        AccomodationRepository $accomodationRepository,
        TarificationRepository $tarificationRepository
    ): Response {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer une réservation (par exemple, la plus récente)
        $booking = $bookingRepository->findOneBy([], ['id' => 'DESC']);

        // Récupérer un hébergement (exemple : premier trouvé)
        $accomodation = $accomodationRepository->findOneBy([], ['id' => 'DESC']);

        // Récupérer une tarification (exemple : dernière entrée)
        $tarification = $tarificationRepository->findOneBy([], ['id' => 'DESC']);

        return $this->render('home/index.html.twig', [
            'title' => 'Bienvenue sur Camping Mars',
            'username' => $user ? $user->getUsername() : 'Messieurs, Dames, et les autres',
            'roles' => $user ? $user->getRoles() : [],
            'user_id' => $user ? $user->getId() : null,

            // Booking
            'nbre_childrens' => $booking ? $booking->getNbreChildrens() : null,
            'nbre_adults' => $booking ? $booking->getNbreAdults() : null,
            'date_start' => $booking ? $booking->getDateStart() : null,
            'date_end' => $booking ? $booking->getDateEnd() : null,

            // Accommodation
            'accomodation_id' => $accomodation ? $accomodation->getId() : null,
            'title_accommodation' => $accomodation ? $accomodation->getTitle() : null,
            'description' => $accomodation ? $accomodation->getDescription() : null,
            'nbre_rooms' => $accomodation ? $accomodation->getNbreBedrooms() : null,
            'is_avaliable' => $accomodation ? $accomodation->getIsAvaliable() : null,
            'image_path' => $accomodation ? $accomodation->getImagePath() : null,
            'size' => $accomodation ? $accomodation->getSize() : null,

            // Tarification
            'season_id' => $tarification ? $tarification->getSeason() : null,
            'price_tarification' => $tarification ? $tarification->getPrice() : null,
        ]);
    }
}
