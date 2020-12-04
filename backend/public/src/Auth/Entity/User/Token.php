<?php
declare(strict_types=1);

namespace App\Auth\Entity\User;

use DomainException;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

class Token
{
    private string $value;
    private DateTimeImmutable $expires;

    public function __construct(string $value, DateTimeImmutable $expires) {
        Assert::uuid($value);
        $this->value = mb_strtolower($value);
        $this->expires = $expires;
    }

    public function validate(string $value, DateTimeImmutable $date): void
    {
        if (!$this->isEqualTo($value)) {
            throw new DomainException("Token is invalid");
        };

        if ($this->isEpiredTo($date)) {
            throw new DomainException("Token is expired");
        };
    }

    public function isEqualTo(string $value): bool
    {
        return $this->value === $value;
    }

    public function isEpiredTo(DateTimeImmutable $value): bool
    {
        return $this->expires <= $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getExpires(): DateTimeImmutable
    {
        return $this->expires;
    }
}
