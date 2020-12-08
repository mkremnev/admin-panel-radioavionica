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
    private ?Email $newEmail = null;
    private ?Token $emailChangeToken = null;
    private Role $role;

    public function __construct(Id $id, DateTimeImmutable $date, Email $email, string $passwordHash, Token $token, Role $role)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->joinConfirmToken = $token;
        $this->status = Status::wait();
        $this->role = Role::user();
    }

    /**
     * confirmJoin
     *
     * @param string $token
     * @param DateTimeImmutable $date
     * @return void
     */
    public function confirmJoin(string $token, DateTimeImmutable $date): void
    {
        if ($this->getJoinConfirmToken() === null) {
            throw new DomainException("Confirmation is not required");
        }
        $this->joinConfirmToken->validate($token, $date);
        $this->status = Status::active();
        $this->joinConfirmToken = null;
    }

    /**
     * requestResetPassword
     *
     * @param Token $token
     * @param DateTimeImmutable $date
     * @return void
     */
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

    /**
     * resetPassword
     *
     * @param string $token
     * @param DateTimeImmutable $date
     * @param string $hash
     * @return void
     */
    public function resetPassword(string $token, DateTimeImmutable $date, string $hash): void
    {
        if ($this->passwordResetToken === null) {
            throw new DomainException("Resetting is not requested");
        }
        $this->passwordResetToken->validate($token, $date);
        $this->passwordResetToken = null;
        $this->passwordHash = $hash;
    }

    /**
     * changePassword
     *
     * @param string $current
     * @param string $new
     * @param PasswordHasher $hasher
     * @return void
     */
    public function changePassword(string $current, string $new, PasswordHasher $hasher): void
    {
        if ($this->passwordHash === null) {
            throw new DomainException("User does not an old password");
        }

        if (!$hasher->validate($current, $this->passwordHash)) {
            throw new DomainException("Incorrect current password");
        }
        $this->passwordHash = $hasher->hash($new);
    }

    /**
     * changeEmailRequest
     *
     * @param Token $token
     * @param DateTimeImmutable $date
     * @param Email $email
     * @return void
     */
    public function changeEmailRequest(Token $token, DateTimeImmutable $date, Email $email)
    {
        if (!$this->isActive()) {
            throw new DomainException("User is not active");
        }
        if ($this->email->isEqualTo($email)) {
            throw new DomainException("Email is already same");
        }
        if ($this->emailChangeToken !== null && !$this->emailChangeToken->isExpiredTo($date)) {
            throw new DomainException("Changing is already requested");
        }
        $this->newEmail = $email;
        $this->emailChangeToken = $token;
    }

    /**
     * confirmEmailChange function
     *
     * @param string $token
     * @param DateTimeImmutable $date
     * @return void
     */
    public function confirmEmailChange(string $token, DateTimeImmutable $date)
    {
        if ($this->newEmail === null || $this->emailChangeToken === null) {
            throw new DomainException("Changing is not required");
        }
        $this->emailChangeToken->validate($token, $date);
        $this->email = $this->newEmail;
        $this->newEmail = null;
        $this->emailChangeToken = null;
    }

    public function changeRole(Role $role): void
    {
        $this->role = $role;
    }

    public function getRole(): Role
    {
        return $this->role;
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

    public function getNewEmail(): Email
    {
        return $this->newEmail;
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

    public function getEmailChangeToken(): ?Token
    {
        return $this->emailChangeToken;
    }
}
