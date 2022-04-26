<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Repository\EquipementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/vospan", name="vp_")
 */
class VotrePanierController extends AbstractController
{
    /**
     * @Route("/", name="vpp")
     */
    public function index(SessionInterface $session,EquipementRepository $equipementRepository)
    {
        $panier = $session->get("panier", []);

        // On "fabrique" les données
        $dataPanier = [];
        $total = 0;
        foreach($panier as $refEquipement => $quantite){
            $equipement = $equipementRepository->find($refEquipement);
        
        array_push($dataPanier, $equipement);
           
            $total += $equipement->getPrixEquipement() * $quantite;
        }

        return $this->render('panierfront/VotrePanier.html.twig', compact("dataPanier", "total"));
    }

    /**
     * @Route("/add/{refEquipement}", name="add")
     */
    public function add(Equipement $equipement, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $refEquipement = $equipement->getRefEquipement();

        if(!empty($panier[$refEquipement])){
            $panier[$refEquipement]++;
        }else{
            $panier[$refEquipement] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);
        
        return $this->redirectToRoute("vp_vpp");
    }

    /**
     * @Route("/remove/{refEquipement}", name="remove")
     */
    public function remove(Equipement $equipement, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $refEquipement = $equipement->getRefEquipement();

        if(!empty($panier[$refEquipement])){
            if($panier[$refEquipement] > 1){
                $panier[$refEquipement]--;
            }else{
                unset($panier[$refEquipement]);
            }
        }
        // On sauvegarde dans la session
        $session->set("panier", $panier);
        return $this->redirectToRoute("vp_vpp");
    }

    /**
     * @Route("/delete/{refEquipement}", name="delete")
     */
    public function delete(Equipement $equipement, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $refEquipement = $equipement->getRefEquipement();
         
        if(!empty($panier[$refEquipement])){
            unset($panier[$refEquipement]);
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("vp_vpp");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("vp_vpp");
    }
}
 