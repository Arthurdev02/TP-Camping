<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $title = "Welcome to the Mars Booking";
        return $this->render('home/index.html.twig', [
            'title' => $title,
            'controller_name' => 'HomeController',
        ]);
    }
}
