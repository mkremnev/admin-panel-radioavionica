<?php

declare(strict_types=1);

namespace App\Military\Query\AllUnits;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;

use function array_push;
use function print_r;

class Handler
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle(Command $command): array
    {
        //if(//TODO ждет реализации TokenAccessRepository для проверки переданного токена доступа)
        $conn = $this->em->getConnection();

        $sql_units = 'select * from military_units';
        $sql_officials = 'select * from military_unit_officials';

        $allUnits = [];
        try {
            $units = $conn->fetchAllAssociative($sql_units);
            $officials = $conn->fetchAllAssociative($sql_officials);
        } catch (Exception $e) {
            throw new DomainException('Error handler query.');
        }

        foreach ($units as $unit) {
            foreach ($officials as $official) {
                if ($unit['id'] === $official['unit_id']) {
                    $unit['officials'][] = $official;
                }
            }
            $allUnits[] = $unit;
        }

        $conn->close();

        return $allUnits;
    }
}
