<?php

namespace App\Controller;
use App\Entity\Client;
use App\Entity\Reclamation;
use App\Entity\Reservation;
use App\Entity\Zonecamping;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;


/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/stats", name="Reservation_stats")
     */
    public function statistics(EntityManagerInterface $entityManager): response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();



        $reservationName = [];
        $reservationCount = [];
        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($reservations as $reservation){
            $reservationName[] = $reservation->getIdReservation();
            $reservationCount[]= count($reservation->getIdReservation());
        }


        return $this->render('reservation/stats.html.twig', [
            'reservationName' => json_encode($reservationName),
            'reservationCount' => json_encode($reservationCount)

        ]);

    }

    /**
     * @Route("/", name="app_reservation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getDoctrine()->getRepository(Client::class)->find($this->getUser());
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findBy(['cin'=>$user->getCin()]);


        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/aff", name="indexBack", methods={"GET"})
     */
    public function indexBack(EntityManagerInterface $entityManager, Request $request,PaginatorInterface $paginator): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        $respagination = $paginator->paginate(
            $reservations,
            $request->query->getInt('page', 1),5
        );

        return $this->render('reservation/indexBack.html.twig', [
            'reservations' => $respagination,

        ]);
    }


    /**
     * @Route("/new", name="app_reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

       $id = ($request->query->getInt('id', 0));
        $zoneCamping = $this->getDoctrine()->getRepository(Zonecamping::class)->find($id);
        $user = $this->getDoctrine()->getRepository(Client::class)->find($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setIdZonecamping($zoneCamping);
            $reservation->setCin($user->getCin()."");
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idReservation}", name="app_reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }
    /**
     * @Route("/{idReservation}/showBackR", name="showBackR", methods={"GET"})
     */
    public function showBack(Reservation $reservation): Response
    {
        return $this->render('reservation/showBackR.html.twig', [
            'reservation' => $reservation,
        ]);
    }
    /**
     * @Route("/{idReservation}/edit", name="app_reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idReservation}", name="app_reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdReservation(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/{idReservation}/deleteBack", name="deleteBack", methods={"POST"})
     */
    public function deleteBack(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdReservation(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('indexBack', [], Response::HTTP_SEE_OTHER);
    }




}
