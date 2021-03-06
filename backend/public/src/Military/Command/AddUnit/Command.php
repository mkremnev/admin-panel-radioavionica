<?php

declare(strict_types=1);

namespace App\Military\Command\AddUnit;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^\d+/")
     */
    public string $name;
    /**
     * @Assert\Type("string")
     */
    public string $address;
    /**
     * @Assert\Type("string")
     */
    public string $lastname;
    /**
     * @Assert\Type("string")
     */
    public string $firstname;
    /**
     * @Assert\Type("string")
     */
    public string $surname;
    /**
     * @Assert\Type("string")
     */
    public string $amount;

    public ?array $officials = null;

    public ?object $files = null;
}
