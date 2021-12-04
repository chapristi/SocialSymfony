<?php
namespace App\Services\Payment\Paypal;
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

class PaymentPaypal implements PaymentPaypalInterface
{

    /**
     * @return Amount
     */
    public function Amount(): Amount
    {
        return $amount = (new Amount())
            ->setCurrency('EUR')
            ->setTotal(50);

    }

    /**
     * @return Payer
     */
    public function Payer(): Payer
    {
        return $payer = (new Payer())
            ->setPaymentMethod("paypal");
    }

    /**
     * @param array $basket
     * @return ItemList
     */
    public function ItemList(array $basket = []): ItemList
    {
        $articles = [
            [
                "name" => "champoing",
                "quantity" => 1,
                "price" => 50,
                "currency" => "EUR"
            ]
        ];
        return $items = (new ItemList())
            ->setItems($articles);
    }

    /**
     * @return Transaction
     */
    public function Transaction(): Transaction
    {
        return $transaction = (new Transaction())
            ->setAmount($this->Amount())
            ->setDescription("description")
            ->setInvoiceNumber(Uuid::uuid4())
            ->setItemList($this->ItemList());
    }

    /**
     * @return RedirectUrls
     */
    public function redirectUrls(): RedirectUrls
    {
        return $redirectUrls = (new RedirectUrls())
            ->setReturnUrl("https://127.0.0.1/good")
            ->setCancelUrl("https://127.0.0.1/cancel");
    }

    /**
     * @return string|null
     */
    public function Payment():?string
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                "Ab6sJeLJJUQtUguEpd40ZRopfrOT51hvN0aUv1Z0K09D9dq2Y3UhZoFPEKewsg_OaT4seKO85Yis_8yz",
                "EDIkP6MdTPd7TQT4iKaN1Y5Ke71fui_5KyWSbNbDRGO6RDqzw3evPw__Pm6E7Zcd5yhvpxnK-hDEZOr5"
            )
        ) ;
        $apiContext ->setConfig([
            'mode' => 'sandbox'
        ]);

        $payment = (new Payment())
            ->setIntent('sale')
            ->setPayer($this->Payer())
            ->setTransactions([$this->Transaction()])
            ->setRedirectUrls($this->redirectUrls());
        try {
            $payment->create($apiContext);

        } catch (PayPalConnectionException $e) {
            dd($e->getData());
        }
        return $payment->getApprovalLink();
    }



}