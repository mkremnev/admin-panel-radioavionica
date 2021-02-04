<?php

declare(strict_types=1);

namespace App\Military\Query\AllDefects;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;

class Handler
{
    private EntityManagerInterface $em;

    /**
     * Handler constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle(Command $command): array
    {
        //if(//TODO ждет реализации TokenAccessRepository для проверки переданного токена доступа)
        $conn = $this->em->getConnection();

        $sql_defects = 'SELECT * from military_defects';
        $sql_notes = 'SELECT * from military_defect_notes';

        $all_defects = [];

        try {
            $defects = $conn->fetchAllAssociative($sql_defects);
            $notes = $conn->fetchAllAssociative($sql_notes);
        } catch (Exception $e) {
            throw new DomainException('Error handler query.');
        }

        foreach ($defects as $defect) {
            foreach ($notes as $note) {
                if ($defect['id'] === $note['defect_id']) {
                    $defect['notes'][] = $note;
                }
            }
            $all_defects[] = $defect;
        }

        $conn->close();

        return $all_defects;
    }
}
