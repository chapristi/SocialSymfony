<?php

namespace App\Controller;

use App\Services\Friend\FriendService;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FriendController extends AbstractController
{
    #[Route('/ajouter-un-amis/{token}', name: 'add_friend')]
    public function index($token,FriendService $friendService): Response
    {
       $friendService -> addFriend($token,$this -> getUser());
       return  $this -> redirectToRoute('main');
    }

    #[Route('/accepter-la-demande/{token}', name: 'accept_friend')]
    public function accept($token,FriendService $friendService): Response
    {
        $friendService -> acceptFriend($token);
        return  $this -> redirectToRoute('main');
    }
}
