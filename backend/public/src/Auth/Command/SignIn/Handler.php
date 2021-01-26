<?php

declare(strict_types=1);

namespace App\Auth\Command\SignIn;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\UserRepository;
use App\Auth\Service\PasswordHasher;
use App\Auth\Service\Tokenizer;
use App\Flusher;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;
    private Tokenizer $tokenizer;
    private PasswordHasher $hasher;

    public function __construct(UserRepository $users, Flusher $flusher, Tokenizer $tokenizer, PasswordHasher $hasher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
        $this->tokenizer = $tokenizer;
        $this->hasher = $hasher;
    }

    public function handle(Command $command): array
    {
        //TODO реализовать передачу токена
        $email = new Email($command->email);
        $user = $this->users->getByEmail($email);

        $user->passwordValidate($command->password, $this->hasher);

        return [
            'id' => $user->getId()->getValue(),
            'email'=> $user->getEmail()->getValue(),
            'role' => $user->getRole()->getName(),
            'status' => $user->isActive(),
            'date' => $user->getDate()
        ];
    }
}
