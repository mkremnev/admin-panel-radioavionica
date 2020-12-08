<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use DomainException;

interface UserRepository
{
    public function hasByEmail(Email $email): bool;
    public function findByConfirmToken(string $token): ?User;
    public function findByEmailChangeToken(string $token): ?User;
    public function findByPasswordResetToken(string $token): ?User;
    /**
     * getId
     *
     * @param Id $id
     * @return User
     * @throws DomainException
     */
    public function getId(Id $id): User;
    /**
     * getByEmai
     *
     * @param Email $email
     * @return User
     * @throws DomainException
     */
    public function getByEmail(Email $email): User;
    public function add(User $user): void;
}
