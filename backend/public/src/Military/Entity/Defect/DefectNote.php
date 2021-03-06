<?php

declare(strict_types=1);

namespace App\Military\Entity\Defect;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="military_defect_notes", uniqueConstraints={
 *      @ORM\UniqueConstraint(columns={"note_notice"})
 * })
 */
class DefectNote
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private string $id;

    /**
     * @var Defect
     * @ORM\ManyToOne(targetEntity="Defect", inversedBy="notes")
     * @ORM\JoinColumn(name="defect_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private Defect $defect;

    /**
     * @ORM\Embedded(class="Note")
     */
    private Note $note;

    /**
     * DefectNote constructor.
     * @param Defect $defect
     * @param Note $note
     */
    public function __construct(Defect $defect, Note $note)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->defect = $defect;
        $this->note = $note;
    }

    /**
     * @return Note
     */
    public function getNote(): Note
    {
        return $this->note;
    }
}
