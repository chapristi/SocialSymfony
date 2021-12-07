<?php
namespace App\Controller;
use App\Entity\Product;
use App\Services\Payment\Basket\Basket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
class CardController extends AbstractController
{
    private   EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this -> entityManager = $entityManager;
    }

    #[Route('/mon-panier', name: 'cart')]
    public function index(Basket $cart): Response
    {

        return $this->render('cart/index.html.twig', [
            'cart' => $cart -> getFull()
        ]);
    }
    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Basket $cart,$id): Response
    {
        $product = $this ->  entityManager -> getRepository(Product::class)->findOneBy(["id" => $id]);
        if (!$product){
            $this -> addFlash("error","vous ne pouvez pas effectuer cette action pour le moment ");
            return $this->redirectToRoute("main");
        }

        $cart -> add($id);
        return $this -> redirectToRoute('main');
    }
    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Basket $cart): Response
    {
        $cart ->remove();
        return $this -> redirectToRoute('main');
    }
    #[Route('/cart/delete/{id}', name: 'delete_to_cart')]
    public function delete(Basket $cart,$id): Response
    {
        $cart ->delete($id);
        return $this -> redirectToRoute('main');
    }
    #[Route('/cart/decrease/{id}', name: 'decrease_to_cart')]
    public function decrease(Basket $cart,$id): Response
    {
        $cart ->decrease($id);
        return $this -> redirectToRoute('main');
    }
}
