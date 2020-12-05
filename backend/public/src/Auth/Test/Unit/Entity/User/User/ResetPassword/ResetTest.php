<?php
declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User\User\ResetPassword;

use App\Auth\Entity\User\Token;
use App\Auth\Test\Builder\UserBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

/**
 * @covers User
 */

class ResetTest extends TestCase
{
    public function testSucces(): void
    {
        $user=(new UserBuilder())->active()->build();

        $now = new DateTimeImmutable();

        $token = $this->createToken($now->modify("+1 hour"));
        $user->requestResetPassword($token, $now);
        self::assertNotNull($user->getResetPasswordToken());

        $user->resetPassword(
            $token->getValue(),
            $now,
            $hash="hash"
        );

        self::assertNull($user->getResetPasswordToken());
        self::assertEquals($hash, $user->getHashPassword());
    }

    public function testInvalidToken(): void
    {
        $user=(new UserBuilder())->active()->build();

        $now = new DateTimeImmutable();

        $token = $this->createToken($now->modify("+1 hour"));
        $user->requestResetPassword($token, $now);

        $this->expectExceptionMessage("Token is invalid");
        $user->resetPassword(
            Uuid::uuid4()->toString(),
            $now,
            $hash="hash"
        );
    }

    public function testExpiredToken(): void
    {
        $user=(new UserBuilder())->active()->build();

        $now = new DateTimeImmutable();

        $token = $this->createToken($now->modify("+1 hour"));
        $user->requestResetPassword($token, $now);

        $this->expectExceptionMessage("Token is expired");
        $user->resetPassword(
            $token->getValue(),
            $now->modify("+1 hour"),
            $hash="hash"
        );
    }

    public function testNotRequested(): void
    {
        $user=(new UserBuilder())->active()->build();

        $now = new DateTimeImmutable();

        $this->expectExceptionMessage("Resetting is not requested");
        $user->resetPassword(
            Uuid::uuid4()->toString(),
            $now,
            $hash="hash"
        );
    }

    public function createToken(DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date
        );
    }
}
