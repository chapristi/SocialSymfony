<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\VerifMail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerifMailController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager )
    {
        $this -> entityManager = $entityManager;
    }
    #[Route('/verifier-mon-mail/{token}', name: 'verif_mail',methods: ['get'])]
    public function index($token): Response
    {
        $IsGood = $this -> entityManager -> getRepository(VerifMail::class)->findOneBy(['token' => $token]);

        if (!$IsGood){
            $this -> addFlash('interdiction',"vous ne pouvez pas acceder a cette page pour le moment");
            return $this -> redirectToRoute('main');

        }
        if (new  \DateTime() > $IsGood -> getCreatedAt()->modify('+ 1 hour')){
            $this -> addFlash('expired' , 'votre token de verification a expiré ');
            return $this->redirectToRoute('main');
        }
        $user = ($this -> entityManager -> getRepository(User::class)->findOneBy(['id' => $IsGood -> getUser()]))
                 -> setIsVerified(1)
        ;
        $this -> entityManager -> flush();
        return  $this->redirectToRoute('main');
    }

}
