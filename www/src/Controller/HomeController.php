<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HebergementRepository; 

class HomeController extends AbstractController
{
    private $hebergementRepository;

    public function __construct(HebergementRepository $hebergementRepository)
    {
        $this->hebergementRepository = $hebergementRepository;
    }

    /**
     * Page d'accueil
     */
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $hebergements = $this->hebergementRepository->findAll();
        return $this->render('home/index.html.twig');
    }

    /**
     * Page "Reservation"
     */
    #[Route('/reservation', name: 'reservation')]
    public function reservation(): Response
    {
        return $this->render('home/reservation.html.twig');
    }
    /**
     * Page "habiation"
     */
    #[Route('/habitation', name: 'listes')]
    public function listes(): Response
    {
        return $this->render('home/habitation.html.twig');
    }
        /**
     * Page "contact"
     */
    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig');
    }
}
