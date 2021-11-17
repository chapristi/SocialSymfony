<?php

namespace App\Controller;

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use Paypal\Auth\OAuthTokenCredential;
use Paypal\Rest\ApiContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentPaypalController extends AbstractController
{
    #[Route('/payment/paypal', name: 'payment_paypal')]
    public function index(): Response
    {

        // After Step 1
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'Ab6sJeLJJUQtUguEpd40ZRopfrOT51hvN0aUv1Z0K09D9dq2Y3UhZoFPEKewsg_OaT4seKO85Yis_8yz',     // ClientID
                'EDIkP6MdTPd7TQT4iKaN1Y5Ke71fui_5KyWSbNbDRGO6RDqzw3evPw__Pm6E7Zcd5yhvpxnK-hDEZOr5'      // ClientSecret
            )
        );

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal('1.00');
        $amount->setCurrency('USD');

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("https://example.com/your_redirect_url.html")
            ->setCancelUrl("https://example.com/your_cancel_url.html");

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);
        try {
            $payment->create($apiContext);
            echo $payment;

            echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData();
        }



        return $this->render('payment_paypal/index.html.twig', [
            'controller_name' => 'PaymentPaypalController',
        ]);
    }
}
