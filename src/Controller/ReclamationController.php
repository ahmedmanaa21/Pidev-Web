<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Client;
use App\Form\ReclamationType;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Knp\Component\Pager\PaginatorInterface;
/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/", name="app_reclamation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getDoctrine()->getRepository(Client::class)->find($this->getUser());
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findBy(['cin'=>$user->getCin()]);

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    /**
     * @Route("/indexBackrec", name="indexBackrec", methods={"GET"})
     */
    public function indexBack(EntityManagerInterface $entityManager, Request $request,PaginatorInterface $paginator): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();

        $recpagination = $paginator->paginate(
            $reclamations,
            $request->query->getInt('page', 1),3
        );

        return $this->render('reclamation/indexBack.html.twig', [
            'reclamations' => $recpagination,

        ]);
    }


    /**
     * @Route("/new", name="app_reclamation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form['screenshot']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $user = $this->getDoctrine()->getRepository(Client::class)->find($this->getUser());
            $reclamation->setCin($user);
            $reclamation->setScreenshot($filename);
            $entityManager->persist($reclamation);
            $entityManager->flush();


            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idRec}", name="app_reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/{idRec}/showBack", name="showBack", methods={"GET"})
     */
    public function showBack(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/showBack.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/{idRec}/edit", name="app_reclamation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //update image
            $file = $form->get('screenshot')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try{
                $file->move(
                    $this->getParameter('upload_directory'),
                    $fileName
                             );
                }
            catch(FileException $e)
                {

                }
            $entityManager = $this->getDoctrine()->getManager();
            $reclamation->setScreenshot($fileName);
            $entityManager->flush();

            $mail=$form['email']->getData();

            $email = (new Email())
                ->from('jasser.boukraya@esprit.tn')
                ->to($mail)
                ->subject('Email a été envoyé !')
                ->text('Votre Réclamation a été prise en Considération ');

            $mailer->send($email);

            return $this->redirectToRoute('indexBackrec', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{idRec}", name="app_reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdRec(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{idRec}/deleteRev", name="deleteRev", methods={"POST"})
     */
    public function deleteBack(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdRec(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('indexBackrec', [], Response::HTTP_SEE_OTHER);
    }
}
