<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
    #[Route('/registration', name: 'registration')]
    public function registration(): Response
    {
        return $this->render('registration/register.html.twig');
    }
    #[Route('/acceuil', name: 'acceuil')]
    public function acceuil(): Response
    {
        return $this->render('home/index.html.twig');
    }
    #[Route('/reservation', name: 'reservation')]
    public function reservation(): Response
    {
        return $this->render('home/index.html.twig');
    }
}


