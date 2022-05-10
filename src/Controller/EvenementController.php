<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/evenementFront", name="app_evenement_front", methods={"GET"})
     */
    public function indexFront(EvenementtRepository $evenementRepository): Response

    {
        return $this->render('evenement/EvenementFront.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/rating", name="rating")
     */
    public function rate(\Symfony\Component\HttpFoundation\Request $request,EvenementtRepository $evenementRepository){
        $data = $request->getContent();
        $obj = json_decode($data,true);

        $em = $this->getDoctrine()->getManager();
        $rate =$obj['rate'];
        $idc = $obj['evenement'];
        $evenement = $evenementRepository->find($idc);
        $note = ($evenement->getRate()*$evenement->getVote() + $rate)/($evenement->getVote()+1);
        $evenement->setVote($evenement->getVote()+1);
        $evenement->setRate($note);
        $em->persist($evenement);
        $em->flush();
        return new Response($evenement->getRate());
    }


    /**
     * @Route("/details/{id}", name="app_evenement_details", methods={"GET"})
     */
    public function indexFrontDetails(EvenementtRepository $evenementRepository,$id): Response

    {
        return $this->render('evenement/EvenementDetails.html.twig', [
            'evenements' => $evenementRepository->find($id),
        ]);
    }

    /**
     * @Route("/", name="app_evenement_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,Request $request, PaginatorInterface $paginator): Response
    {

            $donnees  = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();
        $evenements = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }

    /**
     * @Route("/new", name="app_evenement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setRate(0);
            $evenement->setVote(0);
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }
    /**
     * @Route("/{id}/showFrontE", name="showFrontE", methods={"GET"})
     */
    public function showFront(Evenement $evenement): Response
    {
        return $this->render('evenement/showFront.html.twig', [
            'evenement' => $evenement,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="app_evenement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }


}
