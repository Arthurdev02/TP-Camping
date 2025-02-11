<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HebergementRepository;

class HebergementController extends AbstractController
{
    /**
     * Affiche les détails d'un hébergement
     */
    #[Route('/hebergement/{id}', name: 'hebergement_details')]
    public function show(int $id, HebergementRepository $hebergementRepository): Response
    {
        $hebergement = $hebergementRepository->find($id);

        if (!$hebergement) {
            throw $this->createNotFoundException('Hébergement introuvable.');
        }

        return $this->render('home/hebergement_details.html.twig', [
            'hebergement' => $hebergement
        ]);
    }
}
