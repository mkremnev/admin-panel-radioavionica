<?php

declare(strict_types=1);

namespace App\Military\Entity\Units;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

//TODO убрать уникальность
/**
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="military_unit_officials", uniqueConstraints={
 *      @ORM\UniqueConstraint(columns={"official_subunit", "official_rank", "official_fio", "official_telephone"})
 * })
 */
class UnitOfficial
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private string $id;

    /**
     * @var Unit
     * @ORM\ManyToOne(targetEntity="Unit", inversedBy="officials")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName ="id", nullable=false, onDelete="CASCADE")
     */
    private Unit $unit;

    /**
     * @ORM\Embedded(class="Official")
     */
    private Official $official;

    public function __construct(Unit $unit, Official $official)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->unit = $unit;
        $this->official = $official;
    }

    /**
     * @return Official
     */
    public function getOfficial(): Official
    {
        return $this->official;
    }
}
