<?php

declare(strict_types=1);

namespace App\Auth\Command\ResetPassword\Request;

use App\Flusher;
use DomainException;
use DateTimeImmutable;
use App\Auth\Entity\User\Email;
use App\Auth\Service\Tokenizer;
use App\Auth\Entity\User\UserRepository;
use App\Auth\Service\PasswordResetTokenSender;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;
    private Tokenizer $tokenizer;
    private PasswordResetTokenSender $sender;

    public function __construct(
        UserRepository $users,
        Flusher $flusher,
        Tokenizer $tokenizer,
        PasswordResetTokenSender $sender
    ) {
        $this->users = $users;
        $this->flusher = $flusher;
        $this->tokenizer = $tokenizer;
        $this->sender = $sender;
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);
        $user = $this->users->getByEmail($email);
        $date = new DateTimeImmutable();
        $user->requestResetPassword(
            $token = $this->tokenizer->generate($date),
            $date = new DateTimeImmutable()
        );

        $this->flusher->flush();

        $this->sender->send($email, $token);
    }
}
