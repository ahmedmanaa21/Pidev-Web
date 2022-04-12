<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(): Response
    {
        return $this->render('default/Admin.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    /**
     * @Route("/AddAdmin", name="AddAdmin")
     */
    public function AddAdmin(): Response
    {
        return $this->render('default/AddAdmin.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    /**
     * @Route("/AddClient", name="AddClient")
     */
    public function Client(): Response
    {
        return $this->render('default/AddClient.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
