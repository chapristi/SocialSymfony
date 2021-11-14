<?php

namespace App\Controller;

use App\Services\Friend\FriendService;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FriendController extends AbstractController
{
    #[Route('/ajouter-un-amis/{token}', name: 'add_friend',methods : ["POST"])]
    public function index($token,FriendService $friendService)
    {


        $add = $friendService -> addFriend($token,$this -> getUser() );

        return $this -> json($add,200);




    }

    #[Route('/accepter-la-demande/{token}', name: 'accept_friend',methods : ["POST"])]
    public function accept($token,FriendService $friendService): Response
    {
        $friendService -> acceptFriend($token);

    }
}
