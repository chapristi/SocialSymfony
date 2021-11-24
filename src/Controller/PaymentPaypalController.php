<?php

namespace App\Controller;

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentPaypalController extends AbstractController
{
    #[Route('/payment/paypal', name: 'payment_paypal')]
    public function index(): Response
    {







        return $this->render('payment_paypal/index.html.twig', [
            'controller_name' => 'PaymentPaypalController',
        ]);
    }
}
