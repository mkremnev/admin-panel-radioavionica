<?php

declare(strict_types=1);

namespace App\Military\Entity\Units;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Official
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $subunit;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $rank;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $fio;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $telephone;

    public function __construct(
        string $subunit,
        string $rank,
        string $fio,
        string $telephone
    ) {
        $this->subunit = $subunit;
        $this->rank = $rank;
        $this->fio = $fio;
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getSubUnit(): string
    {
        return $this->subunit;
    }

    /**
     * @return string
     */
    public function getRank(): string
    {
        return $this->rank;
    }

    /**
     * @return string
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    public function isEqualTo(self $official): bool
    {
        return
            $this->getSubUnit() === $official->getSubUnit() &&
            $this->getRank() === $official->getRank() &&
            $this->getFio() === $official->getFio() &&
            $this->getTelephone() === $official->getTelephone();
    }
}
