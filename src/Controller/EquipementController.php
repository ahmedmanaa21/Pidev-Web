<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Form\EquipementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EquipementRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\service\QrcodeService;

/**
 * @Route("/equipement")
 */
class EquipementController extends AbstractController
{
    /**
     * @Route("/front", name="equiFront", methods={"GET"})
     */
    public function indexFront(PaginatorInterface $paginator,EquipementRepository $equipementRepository,Request $request ): Response
    {   $donnee=$equipementRepository->findAll();
        $equipements=$paginator->paginate($donnee,$request->query->getInt('page',1) ,6);
        return $this->render('equipement/indexFront.html.twig', [
            'equipements' => $equipements,
        ]);
    }

    /**
     * @Route("/", name="app_equipement_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,PaginatorInterface $paginator,EquipementRepository $equipementRepository,Request $request  ): Response
    {
        $donnee=$equipementRepository->findAll();
        $equipements=$paginator->paginate($donnee,$request->query->getInt('page',1) ,5);
        return $this->render('equipement/index.html.twig', [
            'equipements' => $equipements,
        ]);
    }


    /**
     * @Route("/new", name="app_equipement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipement->getUploadFile();
            $entityManager->persist($equipement);
            $entityManager->flush();
            $this->addFlash(
                'info' ,
                'added successfully'
            );


            return $this->redirectToRoute('app_equipement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipement/new.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/searchEquipement", name="searchEquipement")
     */

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $equipements =  $em->getRepository(Equipement::class)->findEntitiesByString($requestString);        
        if(!$equipements) {
            $result['equipement']['error'] = "Equipement Introuvable 🙁 ";
        } else {
            $result['equipement'] = $this->getEntities($equipements);
        }
        return new Response(json_encode($result));
    }
    public function getEntities($equipements){
        foreach ($equipements as $equipements){
            $Entities[$equipements->getRefEquipement()] = [$equipements->getImage(),$equipements->getNomEquipement(),$equipements->getPrixEquipement(),$equipements->getDescriptionEquipement()];

        }
        return $Entities;
    }

    /**
     * @Route("/{refEquipement}", name="app_equipement_show", methods={"GET"})
     */
    public function show(Equipement $equipement, QrcodeService $qrcodeService): Response
    {









        $qrCode = null;
        $qrcodeContent = "equipement ".$equipement->getRefEquipement()."\n nom ".$equipement->getNomEquipement()."\n prix".$equipement->getPrixEquipement();
        
        $qrCode = $qrcodeService->qrcode($qrcodeContent);
        return $this->render('equipement/show.html.twig', [
            'equipement' => $equipement,
            'qrCode'  => $qrCode
        ]);
    }

    /**
     * @Route("/{refEquipement}/edit", name="app_equipement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Equipement $equipement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_equipement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipement/edit.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{refEquipement}", name="app_equipement_delete", methods={"POST"})
     */
    public function delete(Request $request, Equipement $equipement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipement->getRefEquipement(), $request->request->get('_token'))) {
            $entityManager->remove($equipement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_equipement_index', [], Response::HTTP_SEE_OTHER);
    }



}



















