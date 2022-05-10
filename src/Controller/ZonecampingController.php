<?php

namespace App\Controller;



use App\Entity\Zonecamping;
use App\Repository\ZoneCampingRepository;
use App\Form\ZonecampingType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/zonecamping")
 */
class ZonecampingController extends AbstractController
{
    /**
     * @Route("/zonecampingFront", name="zonecampingFront", methods={"GET"})
     */
    public function indexFront(ZonecampingRepository $zoneCampingRepository): Response
    {
        return $this->render('zonecamping/ZonecampingFront.html.twig', [
            'zonescamping' => $zoneCampingRepository->findAll(),
        ]);
    }


    /**
     * @Route("/", name="app_zonecamping_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager ,Request $request, PaginatorInterface $paginator): Response
    {
         $donnees  = $entityManager
            ->getRepository(Zonecamping::class)
            ->findAll();
        $zonecampings = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        return $this->render('zonecamping/index.html.twig', [
            'zonecampings' => $zonecampings,
        ]);
    }
    /**
     * @Route("/details/{id}", name="app_zonecamping_details", methods={"GET"})
     */
    public function indexFrontDetails(ZoneCampingRepository $zoneCampingRepository,$id): Response

    {
        return $this->render('zonecamping/ZonecampingDetails.html.twig', [
            'zonecampings' => $zoneCampingRepository->find($id),
        ]);
    }

    /**
     * @Route("/new", name="app_zonecamping_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $zonecamping = new Zonecamping();
        $form = $this->createForm(ZonecampingType::class, $zonecamping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($zonecamping);
            $entityManager->flush();

            return $this->redirectToRoute('app_zonecamping_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('zonecamping/new.html.twig', [
            'zonecamping' => $zonecamping,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_zonecamping_show", methods={"GET"})
     */
    public function show(Zonecamping $zonecamping): Response
    {
        return $this->render('zonecamping/show.html.twig', [
            'zonecamping' => $zonecamping,
        ]);
    }


    /**
     * @Route("/{id}/showFront", name="showFront", methods={"GET"})
     */
    public function showFront(Zonecamping $zonecamping): Response
    {
        return $this->render('zonecamping/showFront.html.twig', [
            'zonecamping' => $zonecamping,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_zonecamping_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Zonecamping $zonecamping, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ZonecampingType::class, $zonecamping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_zonecamping_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('zonecamping/edit.html.twig', [
            'zonecamping' => $zonecamping,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_zonecamping_delete", methods={"POST"})
     */
    public function delete(Request $request, Zonecamping $zonecamping, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$zonecamping->getId(), $request->request->get('_token'))) {
            $entityManager->remove($zonecamping);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_zonecamping_index', [], Response::HTTP_SEE_OTHER);
    }
}
