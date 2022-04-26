<?php

namespace App\Controller;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PayementController extends AbstractController
{
    /**
     * @Route("/payement", name="app_payement")
     */
    public function index(): Response
    {
        return $this->render('payement/index.html.twig', [
            'controller_name' => 'PayementController',
        ]);
    }

    /**
     * @Route("/checkout/{prixtotal}/", name="app_checkout")
     */
    public function checkout($prixtotal): Response
    {

      Stripe::setApiKey('sk_test_51Ksg0NLkofexc0GGwRBBYVsw1GCOtZEaM4KBCoF6f4FwC351FpHEQZ7d4vEUKRNJmKMU6SkymX57UThpUWBoHHN700i86Dsv05');
        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Commande : ',
                    ],
                    'unit_amount' => $prixtotal*100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://127.0.0.1:8000/vospan/delete',
            'cancel_url' => 'https://example.com/cancel',
        ]);
      //  dd($session);
      //  return $response->withHeader('Location', $session->url)->withStatus(303);
        //return $this->redirect($session->url,303);
        return $this->redirect($session->url,303);

    }
}
