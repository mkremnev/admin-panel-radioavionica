<?php

declare(strict_types=1);

namespace App\Military\Entity\Defect;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Fault
 * @ORM\Embeddable
 */
class Fault
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $component;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $mik;

    public function __construct(string $component, string $mik)
    {
        $this->component = $component;
        $this->mik = $mik;
    }

    /**
     * @return string
     */
    public function getComponent(): string
    {
        return $this->component;
    }

    /**
     * @return string
     */
    public function getMik(): string
    {
        return $this->mik;
    }

    public function __toString(): string
    {
        return 'component: ' . $this->getComponent() . '/' . 'mik: ' . $this->getMik();
    }
}
