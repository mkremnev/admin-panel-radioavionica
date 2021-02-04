<?php

declare(strict_types=1);

namespace App\Military\Entity\Defect;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;

class DefectRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repo;

    /**
     * DefectRepository constructor.
     * @param EntityManagerInterface $em
     * @param EntityRepository $repo
     */
    public function __construct(EntityManagerInterface $em, EntityRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }

    public function getId(Id $id): Defect
    {
        if (!$defect = $this->repo->find($id->getValue())) {
            throw new DomainException("Defect is not found.");
        }
        /** @var Defect $defect */
        return $defect;
    }

    public function add(Defect $defect): void
    {
        $this->em->persist($defect);
    }

    public function delete(Defect $defect): void
    {
        $this->em->remove($defect);
    }
}
