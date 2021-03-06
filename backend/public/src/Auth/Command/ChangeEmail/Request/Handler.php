<?php

declare(strict_types=1);

namespace App\Auth\Command\ChangeEmail\Request;

use DomainException;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\Email;
use App\Auth\Service\Tokenizer;
use App\Auth\Service\ChangeEmailSender;
use App\Auth\Entity\User\UserRepository;
use App\Flusher;
use DateTimeImmutable;

class Handler
{
    private UserRepository $users;
    private Tokenizer $tokenizer;
    private ChangeEmailSender $sender;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        Tokenizer $tokenizer,
        Flusher $flusher,
        ChangeEmailSender $sender
    ) {
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
        $this->sender = $sender;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getId(new Id($command->id));

        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new DomainException("Email has already exist.");
        }

        $date = new DateTimeImmutable();

        $user->changeEmailRequest(
            $token = $this->tokenizer->generate($date),
            $date,
            $email
        );

        $this->flusher->flush();
        $this->sender->send($email, $token);
    }
}
