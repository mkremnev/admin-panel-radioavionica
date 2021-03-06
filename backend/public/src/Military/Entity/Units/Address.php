<?php

declare(strict_types=1);

namespace App\Military\Entity\Units;

use Webmozart\Assert\Assert;

class Address
{
    private string $value;

    public function __construct(string $value)
    {

        Assert::stringNotEmpty($value);

        $this->value = mb_strtolower($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(self $equal): bool
    {
        return $this->value === $equal->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
