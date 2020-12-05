<?php
declare(strict_types=1);

namespace App\Auth\Entity\User;

use DomainException;
use DateTimeImmutable;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;
use App\Auth\Service\PasswordHasher;

class User
{
    private Id $id;
    private DateTimeImmutable $date;
    private Email $email;
    private string $passwordHash;
    private ?Token $joinConfirmToken;
    private Status $status;
    private ?Token $passwordResetToken = null;

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

    public function requestResetPassword(Token $token, DateTimeImmutable $date): void
    {
        if (!$this->isActive()) {
            throw new DomainException("User is not active");
        }
        if ($this->passwordResetToken !== null && !$this->passwordResetToken->isExpiredTo($date)) {
            throw new DomainException("Resetting is already requested");
        }
        $this->passwordResetToken = $token;
    }

    public function resetPassword(string $token, DateTimeImmutable $date, string $hash)
    {
        if ($this->passwordResetToken === null) {
            throw new DomainException("Resetting is not requested");
        }
        $this->passwordResetToken->validate($token, $date);
        $this->passwordResetToken = null;
        $this->passwordHash = $hash;
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

    public function getResetPasswordToken(): ?Token
    {
        return $this->passwordResetToken;
    }
}
