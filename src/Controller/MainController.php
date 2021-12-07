<?php

namespace App\Controller;


use App\Services\Payment\Basket\Basket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{


    #[Route('/', name: 'main')]
    public function index(Basket $cart): Response
    {

        return $this->render('main/index.html.twig', [

        ]);
    }
}
