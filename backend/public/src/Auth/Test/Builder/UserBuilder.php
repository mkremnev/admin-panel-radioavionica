<?php

declare(strict_types=1);

namespace App\Auth\Test\Builder;

use DateTimeImmutable;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\User;
use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Role;
use App\Auth\Entity\User\Token;
use Ramsey\Uuid\Nonstandard\Uuid;

class UserBuilder
{
    private Id $id;
    private DateTimeImmutable $date;
    private Email $email;
    private string $passwordHash;
    private ?Token $joinConfirmToken;
    private bool $active = false;
    private Role $role;

    public function __construct()
    {
        $this->id = Id::generate();
        $this->date = new DateTimeImmutable();
        $this->email = new Email("test@test.ru");
        $this->passwordHash = "hash";
        $this->joinConfirmToken = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable());
        $this->role = Role::user();
    }

    public function active(): self
    {
        $clone = clone $this;
        $clone->active = true;
        return $clone;
    }

    public function withJoinConfirmToken(Token $token): self
    {
        $clone = clone $this;
        $clone->joinConfirmToken = $token;
        return $clone;
    }

    public function withEmail(Email $email)
    {
        $clone = clone $this;
        $clone->email = $email;
        return $clone;
    }

    public function build(): User
    {
        $user = new User(
            $this->id,
            $this->date,
            $this->email,
            $this->passwordHash,
            $this->joinConfirmToken,
            $this->role
        );

        if ($this->active) {
            $user->confirmJoin(
                $this->joinConfirmToken->getValue(),
                $this->joinConfirmToken->getExpires()->modify("-1 day")
            );
        }

        return $user;
    }
}
