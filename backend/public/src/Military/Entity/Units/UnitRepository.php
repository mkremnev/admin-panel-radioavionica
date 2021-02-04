<?php

declare(strict_types=1);

namespace App\Military\Entity\Units;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use DomainException;

use function print_r;

class UnitRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em, EntityRepository $repo)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    public function hasByName(Name $name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.name=:name')
                ->setParameter(':name', $name->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function getId(Id $id): Unit
    {
        if (!$units = $this->repo->find($id->getValue())) {
            throw new DomainException("Unit is not found.");
        }
        /** @var Unit $units */
        return $units;
    }

    public function getByName(Name $name): Unit
    {
        if (!$units = $this->repo->findOneBy(['name' => $name->getValue()])) {
            throw new DomainException("Unit is not found.");
        }
        /** @var Unit $units */
        return $units;
    }

    public function add(Unit $units): void
    {
        $this->em->persist($units);
    }

    public function delete(Unit $units): void
    {
        $this->em->remove($units);
    }
}
