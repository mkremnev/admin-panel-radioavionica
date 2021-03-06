<?php

declare(strict_types=1);

namespace App\Military\Entity\Units;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

/**
 * @ORM\Entity
 * @ORM\Table(name="military_units")
 */
class Unit
{
    /**
     * @ORM\Column(type="military_unit_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @ORM\Column(type="military_unit_name")
     */
    private Name $name;

    /**
     * @ORM\Column(type="military_unit_address")
     */
    private Address $address;

    /**
     * @ORM\Embedded(class="Commander")
     */
    private Commander $commander;

    /**
     * @ORM\Column(type="string")
     */
    private string $amount;

    /**
     * @ORM\OneToMany(targetEntity="UnitOfficial", mappedBy="unit", cascade={"all"}, orphanRemoval=true)
     */
    private Collection $officials;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $procuration;

    public function __construct(
        Id $id,
        Name $name,
        Address $address,
        Commander $commander,
        string $amount,
        string $procuration = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->commander = $commander;
        $this->amount = $amount;
        $this->officials = new ArrayCollection();
        $this->procuration = $procuration;
    }

    public function attachOfficials(Official $official): void
    {
        /** @var UnitOfficial $existing */
        foreach ($this->officials as $existing) {
            if ($existing->getOfficial()->isEqualTo($official)) {
                throw new DomainException('Official is already attached.');
            }
        }
        $this->officials->add(new UnitOfficial($this, $official));
    }

    public function attachFiles(string $filename): void
    {
        $this->procuration = $filename;
    }

    /**
     * @return ID
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return Commander
     */
    public function getCommander(): Commander
    {
        return $this->commander;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @return Official[]
     */
    public function getOfficials(): array
    {
        /** @var Official[] */
        return $this->officials->map(static function (UnitOfficial $official) {
            return $official->getOfficial();
        })->toArray();
    }
}
