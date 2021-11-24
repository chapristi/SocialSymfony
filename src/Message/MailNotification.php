<?php
namespace App\Message;

class MailNotification
{
    private string $user_mail;
    private string $body;
    private string $subject;
    private array $params;

    public function __construct(string $user_mail, string $body, string $subject, array $params =  [])
    {
        $this->user_mail= $user_mail;
        $this->body = $body;
        $this->subject = $subject;
        $this -> params = $params;
    }

    public function getUserMail(): string
    {
        return $this->user_mail;
    }
    public function getBody(): string
    {
        return $this->body;
    }
    public function getSubject(): string
    {
        return $this->subject;
    }
    public function getParams(): array
    {
        return $this->params;
    }


}