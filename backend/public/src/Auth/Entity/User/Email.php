<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class Email
{
    private string $value;

    public function __construct(string $value)
    {

        Assert::notEmpty($value);
        Assert::email($value);

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
}
