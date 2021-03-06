<?php

declare(strict_types=1);

namespace App\Military\Entity\Units;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
* @ORM\Embeddable
*/
class Commander
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $lastname;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $firstname;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $surname;

    public function __construct(string $lastname, string $firstname, string $surname)
    {
        Assert::stringNotEmpty($lastname);

        $this->lastname = mb_strtolower($lastname);
        $this->firstname = mb_strtolower($firstname);
        $this->surname = mb_strtolower($surname);
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getFullness(): string
    {
        return $this->lastname . ' ' . $this->firstname . ' ' . $this->surname;
    }

    public function __toString(): string
    {
        return $this->getFullness();
    }
}
