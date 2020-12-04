<?php
declare(strict_types=1);

namespace App\Auth\Entity\User;

use DomainException;
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
    private ?Token $joinConfirmToken;
    private Status $status;

    public function __construct(Id $id, DateTimeImmutable $date, Email $email, string $passwordHash, Token $token) {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->joinConfirmToken = $token;
        $this->status = Status::wait();
    }

    public function confirmJoin(string $token, $date): void
    {
        if ($this->getJoinConfirmToken() === null) {
            throw new DomainException("Confirmation is not required");
        }
        $this->joinConfirmToken->validate($token, $date);
        $this->status = Status::active();
        $this->joinConfirmToken = null;
    }

    public function isWait(): bool
    {
        return $this->status->isWait();
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
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

    public function getJoinConfirmToken(): ?Token
    {
        return $this->joinConfirmToken;
    }
}
