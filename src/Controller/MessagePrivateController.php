<?php

namespace App\Controller;

use App\Entity\BFF;
use App\Entity\MessagePrivate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagePrivateController extends AbstractController
{
    #[Route('/message/private', name: 'message_private')]
    public function index(): Response
    {
        return $this->render('message_private/index.html.twig', [
            'controller_name' => 'MessagePrivateController',
        ]);
    }
    #[Route('/message/direct/{token}', name: 'direct_private')]
    public function direct($token): Response
    {

        $friend = $this ->  getDoctrine() -> getManager() -> getRepository(BFF::class)->findOneBy(["token" => $token]);


        $messages = $this ->  getDoctrine() -> getManager() -> getRepository(MessagePrivate::class)->getMessages($friend -> getSender(), $friend -> getReceiver());

        return $this->render('message_private/index.html.twig', [

        ]);
    }

}
