<?php

declare(strict_types=1);

namespace App\Auth\Command\ChangeEmail\Confirm;

use App\Flusher;
use DomainException;
use DateTimeImmutable;
use App\Auth\Entity\User\UserRepository;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if (!$user = $this->users->findByEmailChangeToken($command->token)) {
            throw new DomainException("Incorrect token.");
        }

        $user->confirmEmailChange($command->token, new DateTimeImmutable());

        $this->flusher->flush();
    }
}
