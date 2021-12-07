<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('boutique/passer-au-rang-superieur', name: 'shop')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $products = $entityManager -> getRepository(Product::class)->findAll();
        return $this->render('shop/index.html.twig', [
            "product" => $products
        ]);
    }


    #[Route('boutique/{slug}', name: 'shop_by_slug')]
    public function Product(EntityManagerInterface $entityManager , $slug): Response
    {
        $product = $entityManager -> getRepository(Product::class)->findOneBy(["slug" => $slug ]);

        return $this->render('shop/bySlug/index.html.twig', [
            "product" => $product
        ]);
    }
}
