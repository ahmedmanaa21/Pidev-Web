<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/", name="app_client_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,Request $request,PaginatorInterface $paginator): Response
    {
        $clients = $entityManager
            ->getRepository(Client::class)
            ->findAll();

        $clientpagination = $paginator->paginate(
            $clients,
            $request->query->getInt('page', 1),3
        );

        return $this->render('client/index.html.twig', [
            'clients' => $clientpagination,
        ]);
    }

    /**
     * @Route("/new", name="app_client_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $encoder): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password

            //upload to directory
            $uploadedFile = $form['image']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $client->setImage($filename);

             // send_sms
            $sid = 'ACd9644583efd696314269fd69b83d04a6';
            $token = '06ac06fef6a6ac9cdf48c19bf8975642';
            $sms = new \Twilio\Rest\Client($sid, $token);

            $sms->messages->create(
                '+21629210244',
                [
                    'from' => '+19039122682',
                    //'+19039122682'
                    //'+14705703238'
                    'body' => 'Hi, your registration was successfully done welcome to CampersDen'

                ]
            );
            
            $client->setPassword($this->passwordEncoder->encodePassword($client, $client->getPassword()));

            // Set their role
             $client->setRoles(['ROLE_USER']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{cin}", name="app_client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{cin}/edit", name="app_client_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //update image
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try{
                $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            }catch(FileException $e){

            }

            //encode password
            $client->setPassword($this->passwordEncoder->encodePassword($client, $client->getPassword()));

            // Set their role
            
            $client->setRoles(['ROLE_USER']);


            $entityManager = $this->getDoctrine()->getManager();
            $client->setImage($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('indexFront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{cin}", name="app_client_delete", methods={"POST"})
     */
    public function delete(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getCin(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('indexFront', [], Response::HTTP_SEE_OTHER);
    }



}
