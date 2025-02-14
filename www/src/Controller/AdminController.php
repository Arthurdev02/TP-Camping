<?php
namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\BookingRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Booking;
use App\Form\UserType;
use App\Form\BookingType;

#[Route('/dashboard/admin')]
class AdminController extends AbstractController
{
    #[Route('/user', name: 'app_admin_users')]
    public function admin_user(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/user/index.html.twig', ['users' => $users]);
    }
    
    #[Route('/user/{id}', name: 'admin_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', ['user' => $user]);
    }
    
    #[Route('/user/new', name: 'admin_user_new', methods: ['GET', 'POST'])]
    public function newUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_users');
        }
        
        return $this->render('admin/user/new.html.twig', ['user' => $user, 'form' => $form]);
    }
    
    #[Route('/user/{id}/edit', name: 'admin_user_edit', methods: ['GET', 'POST'])]
    public function editUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_users');
        }
        
        return $this->render('admin/user/edit.html.twig', ['user' => $user, 'form' => $form]);
    }
    
    #[Route('/user/{id}', name: 'admin_user_delete', methods: ['POST'])]
    public function deleteUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_admin_users');
    }
    
    #[Route('/dashboard', name: 'app_admin_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
    
    #[Route('/bookings', name: 'app_admin_bookings', methods: ['GET'])]
    public function indexBookings(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', ['bookings' => $bookingRepository->findAll()]);
    }
    
    #[Route('/booking/new', name: 'app_admin_booking_new', methods: ['GET', 'POST'])]
    public function newBooking(Request $request, EntityManagerInterface $entityManager): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($booking);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_booking_index');
        }
        
        return $this->render('booking/new.html.twig', ['booking' => $booking, 'form' => $form]);
    }
    
    #[Route('/booking/{id}', name: 'app_admin_booking_show', methods: ['GET'])]
    public function showBooking(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', ['booking' => $booking]);
    }
    
    #[Route('/booking/{id}/edit', name: 'app_admin_booking_edit', methods: ['GET', 'POST'])]
    public function editBooking(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_booking_index');
        }
        
        return $this->render('booking/edit.html.twig', ['booking' => $booking, 'form' => $form]);
    }
    
    #[Route('/booking/{id}', name: 'app_admin_booking_delete', methods: ['POST'])]
    public function deleteBooking(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_admin_booking_index');
    }
}
