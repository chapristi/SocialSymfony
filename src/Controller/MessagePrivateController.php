<?php

namespace App\Controller;

use App\Entity\BFF;
use App\Entity\MessagePrivate;
use App\Form\MessagePrivateType;
use Symfony\Component\HttpFoundation\Request;

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
    public function direct($token , Request $request): Response
    {

        $friend = $this ->  getDoctrine() -> getManager() -> getRepository(BFF::class)->findOneBy(["token" => $token]);



        $messages = $this ->  getDoctrine() -> getManager() -> getRepository(MessagePrivate::class)->getMessages($friend -> getSender(), $friend -> getReceiver());
        $PrivateMessages = new MessagePrivate();
        $form = $this -> createForm(MessagePrivateType::class,$PrivateMessages);
        $form -> handleRequest($request);
        if ($form -> isSubmitted() && $form -> isValid())
        {
            $PrivateMessages = $form-> getData();
            $PrivateMessages -> setSender($this -> getUser());
            if ($this -> getUser() === $friend -> getSender()){
                $PrivateMessages -> setReceiver($friend -> getReceiver());
            }else{
                $PrivateMessages -> setReceiver($friend -> getReceiver());

            }
            $this ->  getDoctrine() -> getManager() -> persist($PrivateMessages);
            $this -> getDoctrine() -> getManager() -> flush();


        }


        return $this->render('message_private/index.html.twig', [
            'form' => $form -> createView(),

        ]);
    }

}
