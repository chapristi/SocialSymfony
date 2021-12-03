<?php

namespace App\Controller\Payment\Paypal;
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
    public function index(): Response
    {

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                "Ab6sJeLJJUQtUguEpd40ZRopfrOT51hvN0aUv1Z0K09D9dq2Y3UhZoFPEKewsg_OaT4seKO85Yis_8yz",
                "EDIkP6MdTPd7TQT4iKaN1Y5Ke71fui_5KyWSbNbDRGO6RDqzw3evPw__Pm6E7Zcd5yhvpxnK-hDEZOr5"
            )
        );
        $payer = (new Payer())
            ->setPaymentMethod("paypal");

        $apiContext->setConfig([
            'mode' => 'sandbox'
        ]);

        $amount = (new Amount())
            ->setCurrency('EUR')
            ->setTotal(50);

        $items = (new ItemList())
            ->setItems([

                "name" => "champoing",
                "quantity" => 1,
                "price" => 50,
                "currency" => "EUR"
            ]);
        $transaction = (new Transaction())
            ->setAmount($amount)
            ->setDescription("description")
            ->setInvoiceNumber(Uuid::uuid4())
            ->setItemList($items);
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("https://127.0.0.1/good")
            ->setCancelUrl("https://127.0.0.1/cancel");
        $payment = (new Payment())
            ->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);
        try {
            $payment->create($apiContext);

        } catch (PayPalConnectionException $e) {
            dd($e->getData());
        }
        header('location:' . $payment->getApprovalLink());


    }


}
