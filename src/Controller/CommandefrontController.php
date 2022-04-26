<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\Commande1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use MercurySeries\FlashBundle\FlashNotifier;
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * @Route("/commandefront")
 */
class CommandefrontController extends AbstractController
{
    /**
     * @Route("/", name="app_commandefront_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commandefront/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/new", name="app_commandefront_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {  
        $commande = new Commande();
        $form = $this->createForm(Commande1Type::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

         $this->addFlash('info','Added successfully!');
         
        $mail=$form['adressmail']->getData();
            // var_dump($mail) ; 
             //die ; 
        $email = (new Email())
        ->from('nourridha.dhaouadi@gmail.com')
        ->to($mail)
        ->subject('Time for Symfony Mailer!')
        ->text('votre commande est validé!');

        $mailer->send($email);
            return $this->redirectToRoute('app_commandefront_index', [], Response::HTTP_SEE_OTHER);
        }

        $numTel=$form['numTel']->getData();
        $sid = 'ACd5f1f07e2af7fbc1d0c1b361154d7262';
        $token = 'd397e83576aa5a8d2ffca44e4c4899e3';
        $sms = new \Twilio\Rest\Client($sid, $token);

        $sms->messages->create(
          '$numTel',
            [
                'from' => '+12392913891',
                'body' => 'Hi,your your order is in progress '

            ]
        );
        

        return $this->render('commandefront/new.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCmd}", name="app_commandefront_show", methods={"GET"})
     */
    public function show(Commande $commande): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
      
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('commandefront/show.html.twig', [
            'commande' => $commande,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
        
     
    }

    /**
     * @Route("/{idCmd}/edit", name="app_commandefront_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Commande1Type::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commandefront_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commandefront/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCmd}", name="app_commandefront_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getIdCmd(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        
        $this->addFlash('info','Deleted successfully!');
        return $this->redirectToRoute('app_commandefront_index', [], Response::HTTP_SEE_OTHER);
    }

   
}
}