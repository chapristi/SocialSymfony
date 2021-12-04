<?php

namespace App\Controller\Payment\Paypal;
use App\Services\Payment\Paypal\PaymentPaypal;
use PayPal\Api\Amount;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentPaypalController extends AbstractController
{
    #[Route('/payment/paypal', name: 'payment_paypal')]
    public function index(PaymentPaypal $paymentPaypal): Response
    {


        return $this -> redirect($paymentPaypal->Payment());




    }


}
