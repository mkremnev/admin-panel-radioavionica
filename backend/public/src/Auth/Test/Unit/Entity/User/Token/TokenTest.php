<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use App\Auth\Entity\User\Token;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

/**
 * @covers Token
 */

class TokenTest extends TestCase
{
    public function testSucces(): void
    {
        $token = new Token(
            $value = Uuid::uuid4()->toString(),
            $expires = new DateTimeImmutable()
        );

        Assert::assertEquals($value, $token->getValue());
        Assert::assertEquals($expires, $token->getExpires());
    }

    public function testCase(): void
    {
        $now = new DateTimeImmutable();
        $value = Uuid::uuid4()->toString();

        $token = new Token(mb_strtolower($value), $now);

        Assert::assertEquals($value, $token->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Token('1234', new DateTimeImmutable());
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Token('', new DateTimeImmutable());
    }
}
