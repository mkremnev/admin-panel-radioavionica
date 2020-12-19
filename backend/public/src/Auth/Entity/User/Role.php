<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use Webmozart\Assert\Assert;

class Role
{
    public const ADMIN = 'admin';
    public const USER = 'user';

    private string $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::USER,
            self::ADMIN
        ]);

        $this->name = $name;
    }

    public static function user(): self
    {
        return new self(self::USER);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
