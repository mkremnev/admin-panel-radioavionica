<?php

declare(strict_types=1);

namespace App\Military\Entity\Defect;

use Webmozart\Assert\Assert;

class Unit
{
    private string $value;

    public function __construct(string $value)
    {

        Assert::stringNotEmpty($value);

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
