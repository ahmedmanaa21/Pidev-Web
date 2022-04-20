<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\Panier1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/panierfront")
 */
class PanierfrontController extends AbstractController
{
    /**
     * @Route("/", name="app_panierfront_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $paniers = $entityManager
            ->getRepository(Panier::class)
            ->findAll();

        return $this->render('panierfront/index.html.twig', [
            'paniers' => $paniers,
        ]);
    }

    /**
     * @Route("/new/{$id}", name="app_panierfront_new")
     */
    public function new($id){
    
       $idprd = $this->getDoctrine()->getRepository(Equipement::class)->find($id);
       
       $panier = new Panier();
       $panier->setNompanier("Disponible") ;
        $panier->setNbrequipement(1) ;
        $panier->setRefequipement($idprd) ;
        $panier->setPrixequipement() ;
    
      
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($panier);
            $em->flush();
           $this->addFlash('success', 'Article Created! Knowledge is power!');

    

               return $this->redirectToRoute("app_panierfront_index");
        
    
}

    /**
     * @Route("/{idPanier}", name="app_panierfront_show", methods={"GET"})
     */
    public function show(Panier $panier): Response
    {
        return $this->render('panierfront/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    /**
     * @Route("/{idPanier}/edit", name="app_panierfront_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Panier1Type::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_panierfront_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panierfront/edit.html.twig', [
            'panier' => $panier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPanier}", name="app_panierfront_delete", methods={"POST"})
     */
    public function delete(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getIdPanier(), $request->request->get('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panierfront_index', [], Response::HTTP_SEE_OTHER);
    }
}
 