<?php

namespace App\Controller;

use App\Services\Payment\Basket\Basket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function index(Basket $cart): Response
    {

        return $this->render('account/index.html.twig', [
            "basket" => $cart->getFull()
        ]);
    }
}
