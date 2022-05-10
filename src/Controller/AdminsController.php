<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/admins")
 */
class AdminsController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/IndexAdmin", name="app_admins_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,Request $request,PaginatorInterface $paginator): Response
    {
        $admins = $entityManager
            ->getRepository(Admin::class)
            ->findAll();

        $adminpagination = $paginator->paginate(
            $admins,
            $request->query->getInt('page', 1),3
        );

        return $this->render('admins/index.html.twig', [
            'admins' => $adminpagination,
        ]);
    }

    /**
     * @Route("/", name="app_admins_new", methods={"GET", "POST"})
     */
    public function addAdmin(Request $request, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $encoder): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $admin->setPassword($this->passwordEncoder->encodePassword($admin, $admin->getPassword()));

            // Set their role
            $admin->setRoles(['ROLE_ADMIN']);

            $entityManager = $this->getDoctrine()->getManager();
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
            //encode password
            $admin->setPassword($this->passwordEncoder->encodePassword($admin, $admin->getPassword()));

            // Set their role

            $admin->setRoles(['ROLE_ADMIN']);
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
    /**
     * @Route("/search/back", name="adminAjax", methods={"GET"})
     */
    public function search(Request $request ) :Response
    {
        $AdminRepository = $this->getDoctrine()->getRepository(Admin::class);
        $requestString=$request->get('searchValue');
        $admin = $AdminRepository->findByNom($requestString);
        return $this->render('admins/adminAjax.html.twig', [
            'admins' => $admin,
        ]);
    }

    public function getRealEntities($entities){

        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getNom();
        }
        return $realEntities;
    }

}
