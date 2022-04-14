<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admins")
 */
class AdminsController extends AbstractController
{
    /**
     * @Route("/IndexAdmin", name="app_admins_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $admins = $entityManager
            ->getRepository(Admin::class)
            ->findAll();

        return $this->render('admins/index.html.twig', [
            'admins' => $admins,
        ]);
    }

    /**
     * @Route("/", name="app_admins_new", methods={"GET", "POST"})
     */
    public function addAdmin(Request $request, EntityManagerInterface $entityManager): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('app_admins_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admins/new.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_admins_show", methods={"GET"})
     */
    public function show(Admin $admin): Response
    {
        return $this->render('admins/show.html.twig', [
            'admin' => $admin,
        ]);
    }

    /**
     * @Route("/{id}/editAdmin", name="app_admins_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Admin $admin, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admins_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admins/edit.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/deleteAdmin", name="app_admins_delete", methods={"POST"})
     */
    public function delete(Request $request, Admin $admin, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {
            $entityManager->remove($admin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admins_index', [], Response::HTTP_SEE_OTHER);
    }
}
