<?php

declare(strict_types=1);

namespace App\Military\Entity\Defect;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class Id
{
    /**
     * @var string $value
     */
    private string $value;

    public function __construct(string $value)
    {
        Assert::uuid($value);

        $this->value = mb_strtolower($value);
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
