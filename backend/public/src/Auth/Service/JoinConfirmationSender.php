<?php

declare(strict_types=1);

namespace App\Auth\Service;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;
use App\Frontend\FrontendUrlGenerator;
use RuntimeException;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

use function http_build_query;

class JoinConfirmationSender
{
    private Swift_Mailer $mailer;
    private FrontendUrlGenerator $frontend;
    private Environment $twig;

    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send(Email $email, Token $token): void
    {
        $message = (new Swift_Message('Join confirmation'))
            ->setTo($email->getValue())
            ->setBody($this->twig->render('auth/join/confirm.html.twig', ['token' => $token]), 'text/html');

        if ($this->mailer->send($message) === 0) {
            throw new RuntimeException('Unable to send mail');
        }
    }
}
