<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use DomainException;

class UserRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repo;

    /**
     * @param EntityManagerInterface $em
     * @param EntityRepository $repo
     * @psalm-param EntityRepository<User> $repo
     */
    public function __construct(EntityManagerInterface $em, EntityRepository $repo)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    public function hasByEmail(Email $email): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.email=:email')
                ->setParameter(':email', $email->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    /**
     * @param string $token
     * @return User|object|null
     * @psalm-return User|null
     */
    public function findByConfirmToken(string $token): ?User
    {
        /** @psalm-var User|null */
        return $this->repo->findOneBy(['confirmToken.value' => $token]);
    }

    /**
     * @param string $token
     * @return User|object|null
     * @psalm-return User|null
     */
    public function findByEmailChangeToken(string $token): ?User
    {
        /** @psalm-var User|null */
        return $this->repo->findOneBy(['emailChangeToken.value' => $token]);
    }

    /**
     * @param string $token
     * @return User|object|null
     * @psalm-return User|null
     */
    public function findByPasswordResetToken(string $token): ?User
    {
        /** @psalm-var User|null */
        return $this->repo->findOneBy(['passwordResetToken.value' => $token]);
    }

    /**
     * getId
     *
     * @param Id $id
     * @return User
     * @throws DomainException
     */
    public function getId(Id $id): User
    {
        if (!$user = $this->repo->find($id->getValue())) {
            throw new DomainException("User is not found.");
        }
        /** @var User $user */
        return $user;
    }

    /**
     * getByEmail
     *
     * @param Email $email
     * @return User
     * @throws DomainException
     */
    public function getByEmail(Email $email): User
    {
        if (!$user = $this->repo->findOneBy(['email' => $email->getValue()])) {
            throw new DomainException("User is not found.");
        }
        /** @var User $user */
        return $user;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }
}
