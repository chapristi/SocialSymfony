<?php

namespace App\Controller;

use App\Entity\BFF;
use App\Entity\MessagePrivate;
use phpDocumentor\Reflection\DocBlock\Serializer;
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
        

        return $this->render('message_private/index.html.twig', [

        ]);
    }
    #[Route('/message/add/{token}', name: 'add_direct_private' , methods: ["POST"])]
    public function add($token , Request $request): Response
    {

            $friend = $this ->  getDoctrine() -> getManager() -> getRepository(BFF::class)->findOneBy(["token" => $token]);

            $PrivateMessages = new MessagePrivate();

            $PrivateMessages -> setSender($this -> getUser());
            $PrivateMessages -> setMessage($request  -> toArray()['message']);
            if ($this -> getUser() === $friend -> getSender()){
                $PrivateMessages -> setReceiver($friend -> getReceiver());
            }else{
                $PrivateMessages -> setReceiver($friend -> getSender());

            }
            $this ->  getDoctrine() -> getManager() -> persist($PrivateMessages);
            $this -> getDoctrine() -> getManager() -> flush();

            return $this -> json(["message" => "message bien envoyé" ,'code' => 200  ]);


    }
    #[Route('/message/get/{token}', name: 'get_direct_private' , methods: ["POST"])]

    public function getMessages( $token , Request $request)
    {
        $friend = $this ->  getDoctrine() -> getManager() -> getRepository(BFF::class)->findOneBy(["token" => $token]);



        $messages = $this ->  getDoctrine() -> getManager() -> getRepository(MessagePrivate::class)->getMessages($friend -> getSender(), $friend -> getReceiver());

        $jsonMessages = [];
        foreach ($messages as   $message){
            $jsonMessages[]  = [
                'sender' => $message -> getSender() -> getUsername(),
                'receiver' => $message -> getReceiver() -> getUsername(),
                'message' => $message -> getMessage(),
                'createdAt' => new \DateTime($message -> getCreatedAt()->format('Y-m-d H:i:s')),
            ];
        }


        return $this ->json(
            $jsonMessages,200
        );
    }


}
