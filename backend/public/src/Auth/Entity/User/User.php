<?php
declare(strict_types=1);

namespace App\Auth\Entity\User;

use DateTimeImmutable;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;

class User
{
    private Id $id;
    private DateTimeImmutable $date;
    private Email $email;
    private string $passwordHash;
    private ?Token $token;

    public function __construct(Id $id, DateTimeImmutable $date, Email $email, string $passwordHash, Token $token) {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->token = $token;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getHashPassword(): ?string
    {
        return $this->passwordHash;
    }

    public function getToken(): ?Token
    {
        return $this->token;
    }
}
