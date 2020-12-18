<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User\Token;

use App\Auth\Entity\User\Token;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

/**
 * @covers Token::isExpiredTo
 */

class ExpiredTest extends TestCase
{
    public function testNot(): void
    {
        $token = new Token(
            $value = Uuid::uuid4()->toString(),
            $date = new DateTimeImmutable()
        );

        self::assertFalse($token->isExpiredTo($date->modify("-1 sec")));
        self::assertTrue($token->isExpiredTo($date));
        self::assertTrue($token->isExpiredTo($date->modify("+1 sec")));
    }
}
