<?php
namespace  App\Services\Payment\Paypal;
use PayPal\Api\Amount;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

interface  PaymentPaypalInterface
{
    public function Amount():Amount;
    public function Payer():Payer;
    public function ItemList(array $basket = []):ItemList;
    public function Transaction():Transaction;
    public function redirectUrls():RedirectUrls;
    public function Payment():?string;
}