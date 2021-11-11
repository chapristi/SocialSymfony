<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\VerifMail;
use App\Form\RegisterType;
use App\Services\Mail\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $entityManager;

    public  function  __construct(EntityManagerInterface $entityManager)
    {
        $this -> entityManager = $entityManager;
    }
    #[Route('/creer-votre-compte', name: 'register')]
    public function index(Request $request,UserPasswordHasherInterface $passwordHasher, MailService $mail ): Response
    {
        $notification = null;
        $user = new User();
        $form =  $this ->createForm(RegisterType::class,$user);

        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form -> isValid()) {
            $user = $form-> getData();
            $sameMail  = $this -> entityManager -> getRepository(User::class)->findOneByEmail($user -> getEmail());
            if(!$sameMail){
                $password = $passwordHasher->hashPassword(
                    $user,
                    $user -> getPassword()
                );
                $user -> setPassword($password);
                $user -> setToken(Uuid::uuid4());
                $this -> entityManager -> persist($user);
                $token =  Uuid::uuid4();

                $verifMail = (new  VerifMail())
                   ->setUser($user)
                   ->setCreatedAT(new \DateTime())
                   ->setToken($token)
              ;
                $this -> entityManager -> persist($verifMail);
                $this -> entityManager -> flush();

                $mail -> sendMail(
                    $user->getEmail(),
                   'emaiil/email.html.twig',
                    "Vous pouvez deshormais verifier votre compte",
                    [
                        'uuid' => $token,
                    ]);

                }
                else{
                    $notification = "L'email renseigné ne peut pas etre utilisé";
                }
            }

            return $this->render('register/index.html.twig', [
                "form" => $form->createView(),
                "notification" => $notification
        ]);
    }
}
