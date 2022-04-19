<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use App\Repository\EquipementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\service\MailerService;
/**
 * @Route("/offre")
 */
class OffreController extends AbstractController
{



      /**
     * @Route("/front", name="offreFront", methods={"GET"})
     */
    public function indexFront(OffreRepository $offreRepository,EquipementRepository $equipementRepository): Response

    {
       
        return $this->render('offre/frontoffre.html.twig', [
            'offres' =>     $offreRepository->findAll()
        ]);
    } 


    /**
     * @Route("/", name="app_offre_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $offres = $entityManager
            ->getRepository(Offre::class)
            ->findAll();

        return $this->render('offre/index.html.twig', [
            'offres' => $offres,
        ]);
    }

    /**
     * @Route("/new", name="app_offre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,\Swift_Mailer $mailer,
    MailerService $mailerService): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }
        
        $mailerService->send(
            "b",
            "maissa.choura.antar@esprit.tn",
            "mohamediheb.berraies@esprit.tn",
            
            "MailTemplate/emailTemplate.html.twig");

        return $this->render('offre/new.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPromotion}", name="app_offre_show", methods={"GET"})
     */
    public function show(Offre $offre): Response
    {
        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    /**
     * @Route("/{idPromotion}/edit", name="app_offre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/edit.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPromotion}", name="app_offre_delete", methods={"POST"})
     */
    public function delete(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getIdPromotion(), $request->request->get('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
    }
}
