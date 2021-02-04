<?php

declare(strict_types=1);

use App\Military\Entity\Defect\Defect;
use App\Military\Entity\Defect\DefectRepository;
use App\Military\Entity\Units\Unit;
use App\Military\Entity\Units\UnitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

return [
    UnitRepository::class => function (ContainerInterface $container): UnitRepository {
        $em = $container->get(EntityManagerInterface::class);
        /**
         * @var EntityRepository $repo
         * @psalm-var EntityRepository<Unit> $repo
         */
        $repo = $em->getRepository(Unit::class);
        return new UnitRepository($em, $repo);
    },
    DefectRepository::class => function (ContainerInterface $container): DefectRepository {
        $em = $container->get(EntityManagerInterface::class);
        /**
         * @var EntityRepository $repo
         * @psalm-var EntityRepository<Unit> $repo
         */
        $repo = $em->getRepository(Defect::class);
        return new DefectRepository($em, $repo);
    }
];
