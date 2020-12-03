<?php
declare(strict_types=1);

namespace App\Auth\Entity\User;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class Email
{
    private string $value;

    public function __construct(string $value) {

        Assert::notEmpty($value);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email incorrect");
        }

        $this->value = mb_strtolower($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}
