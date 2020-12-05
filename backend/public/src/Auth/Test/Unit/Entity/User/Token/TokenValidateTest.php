<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User\User\Token;

use App\Auth\Entity\User\Token;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

class TokenValidateTest extends TestCase
{
    public function testSuccess(): void
    {
        $token = new Token(
            $expect = Uuid::uuid4()->toString(),
            $expires = new DateTimeImmutable()
        );

        $token->validate($expect, $expires->modify("-1 sec"));
    }

    public function testInvalid(): void
    {
        $token = new Token(
            $expect = Uuid::uuid4()->toString(),
            $expires = new DateTimeImmutable()
        );

        $this->expectExceptionMessage("Token is invalid");
        $token->validate(Uuid::uuid4()->toString(), $expires->modify("-1 sec"));
    }

    public function testExpired(): void
    {
        $token = new Token(
            $expect = Uuid::uuid4()->toString(),
            $expires = new DateTimeImmutable()
        );

        $this->expectExceptionMessage("Token is expired");
        $token->validate($expect, $expires->modify("+1 sec"));
    }
}
