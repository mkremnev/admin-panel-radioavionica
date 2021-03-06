<?php

declare(strict_types=1);

namespace App\Military\Entity\Defect;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="military_defects")
 */
class Defect
{
    /**
     * @ORM\Column(type="military_defect_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @ORM\Column(type="military_defect_unit")
     */
    private Unit $unit;

    /**
     * @ORM\Column(type="string")
     */
    private string $responsible;

    /**
     * @ORM\Column(type="military_defect_district")
     */
    private District $district;

    /**
     * @ORM\Column(type="string")
     */
    private string $amount;

    /**
     * @ORM\Column(type="string")
     */
    private string $deliveryYear;

    /**
     * @ORM\Column(type="string")
     */
    private string $commissioningDate;

    /**
     * @ORM\Column(type="string")
     */
    private string $warranty;

    /**
     * @ORM\Column(type="string")
     */
    private string $nonWarranty;

    /**
     * @ORM\Embedded(class="Fault")
     */
    private Fault $fault;

    /**
     * @ORM\Embedded(class="Components")
     */
    private Components $components;

    /**
     * @ORM\OneToMany(targetEntity="DefectNote", mappedBy="defect", cascade={"all"}, orphanRemoval=true)
     */
    private Collection $notes;

    /**
     * Defect constructor.
     * @param ID $id
     * @param Unit $unit
     * @param string $responsible
     * @param District $district
     * @param string $amount
     * @param string $deliveryYear
     * @param string $commissioningDate
     * @param string $warranty
     * @param string $nonWarranty
     * @param Fault $fault
     * @param Components $components
     */
    public function __construct(
        Id $id,
        Unit $unit,
        string $responsible,
        District $district,
        string $amount,
        string $deliveryYear,
        string $commissioningDate,
        string $warranty,
        string $nonWarranty,
        Fault $fault,
        Components $components
    ) {
        $this->id = $id;
        $this->unit = $unit;
        $this->responsible = $responsible;
        $this->district = $district;
        $this->amount = $amount;
        $this->deliveryYear = $deliveryYear;
        $this->commissioningDate = $commissioningDate;
        $this->warranty = $warranty;
        $this->nonWarranty = $nonWarranty;
        $this->fault = $fault;
        $this->components = $components;
        $this->notes = new ArrayCollection();
    }

    public function attachNotes(Note $note): void
    {
        $this->notes->add(new DefectNote($this, $note));
    }

    /**
     * @return ID
     */
    public function getId(): ID
    {
        return $this->id;
    }

    /**
     * @return Unit
     */
    public function getUnit(): Unit
    {
        return $this->unit;
    }

    /**
     * @return string
     */
    public function getResponsible(): string
    {
        return $this->responsible;
    }

    /**
     * @return District
     */
    public function getDistrict(): District
    {
        return $this->district;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getDeliveryYear(): string
    {
        return $this->deliveryYear;
    }

    /**
     * @return string
     */
    public function getCommissioningDate(): string
    {
        return $this->commissioningDate;
    }

    /**
     * @return string
     */
    public function getWarranty(): string
    {
        return $this->warranty;
    }

    /**
     * @return string
     */
    public function getNonWarranty(): string
    {
        return $this->nonWarranty;
    }

    /**
     * @return Fault
     */
    public function getFault(): Fault
    {
        return $this->fault;
    }

    /**
     * @return Components
     */
    public function getComponents(): Components
    {
        return $this->components;
    }

    /**
     * @return Note[]
     */
    public function getNotes(): array
    {
        /** @var Note[] */
        return $this->notes->map(static function (DefectNote $note) {
            return $note->getNote();
        })->toArray();
    }
}
