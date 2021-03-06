<?php

declare(strict_types=1);

namespace App\Military\Entity\Defect;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Note
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $notice;

    /**
     * Note constructor.
     * @param string $notice
     */
    public function __construct(string $notice)
    {
        $this->notice = $notice;
    }

    /**
     * @return string
     */
    public function getNotice(): string
    {
        return $this->notice;
    }
}
