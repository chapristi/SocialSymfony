<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\Friend\FriendService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    private EntityManagerInterface $entityManager;


    public  function  __construct(EntityManagerInterface $entityManager)
    {
        $this -> entityManager = $entityManager;
    }
    #[Route('/profile/{user}', name: 'profile')]
    public function index($user, FriendService $friendService): Response
    {

        $user = $this -> entityManager -> getRepository(User::class)->findOneBy(['email' => $user]);
        $isFriend  = $friendService -> isFriend($this -> getUser() , $user);
        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'isFriend' => $isFriend,

        ]);
    }
}
