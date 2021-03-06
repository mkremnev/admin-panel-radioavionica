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
    private string $hash;
    private ?Token $confirmToken;
    private bool $active = false;
    private Role $role;

    public function __construct()
    {
        $this->id = Id::generate();
        $this->email = new Email('mail@example.com');
        $this->hash = 'hash';
        $this->date = new DateTimeImmutable();
        $this->confirmToken = new Token(Uuid::uuid4()->toString(), $this->date->modify('+1 day'));
    }


    public function withJoinConfirmToken(Token $token): self
    {
        $clone = clone $this;
        $clone->confirmToken = $token;
        return $clone;
    }

    /**
     * @param Email $email
     * @return static
     */
    public function withEmail(Email $email): self
    {
        $clone = clone $this;
        $clone->email = $email;
        return $clone;
    }

    public function active(): self
    {
        $clone = clone $this;
        $clone->active = true;
        return $clone;
    }

    public function build(): User
    {
            $user = User::requestJoinByEmail(
                $this->id,
                $this->date,
                $this->email,
                $this->hash,
                $this->confirmToken
            );

        if ($this->active) {
            $user->confirmJoin(
                $this->confirmToken->getValue(),
                $this->confirmToken->getExpires()->modify('-1 day')
            );
        }

        return $user;
    }
}
