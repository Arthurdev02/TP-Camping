<?php

namespace App\Controller;

use App\Entity\Tarification;
use App\Form\TarificationType;
use App\Repository\TarificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tarification')]
final class TarificationController extends AbstractController
{
    #[Route(name: 'app_tarification_index', methods: ['GET'])]
    public function index(TarificationRepository $tarificationRepository): Response
    {
        return $this->render('tarification/index.html.twig', [
            'tarifications' => $tarificationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tarification_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tarification = new Tarification();
        $form = $this->createForm(TarificationType::class, $tarification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tarification);
            $entityManager->flush();

            return $this->redirectToRoute('app_tarification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tarification/new.html.twig', [
            'tarification' => $tarification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarification_show', methods: ['GET'])]
    public function show(Tarification $tarification): Response
    {
        return $this->render('tarification/show.html.twig', [
            'tarification' => $tarification,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tarification_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tarification $tarification, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TarificationType::class, $tarification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tarification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tarification/edit.html.twig', [
            'tarification' => $tarification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarification_delete', methods: ['POST'])]
    public function delete(Request $request, Tarification $tarification, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tarification->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tarification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tarification_index', [], Response::HTTP_SEE_OTHER);
    }
}
