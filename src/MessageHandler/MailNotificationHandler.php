<?php

namespace App\MessageHandler;

use App\Message\MailNotification;
use App\Services\Mail\MailService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailNotificationHandler implements MessageHandlerInterface
{
    private MailService $mail;

    public function __construct(MailService $mail)
    {
        $this -> mail = $mail;
    }

    public function __invoke(MailNotification $message)
    {
        $this -> mail -> sendMail(

            $message->getUserMail(),
            $message -> getSubject(),
            $message -> getBody(),
            $message -> getParams(),

        );


    }
}