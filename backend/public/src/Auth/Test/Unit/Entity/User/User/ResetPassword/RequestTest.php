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

class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->active()->build();

        $date = new DateTimeImmutable();
        $token = $this->createToken($date->modify("+1 hour"));

        $user->requestResetPassword($token, $date);

        self::assertNotNull($user->getResetPasswordToken());
        self::assertEquals($token, $user->getResetPasswordToken());
    }

    public function testAlready(): void
    {
        $user = (new UserBuilder())->active()->build();

        $date = new DateTimeImmutable();
        $token = $this->createToken($date->modify("+1 hour"));

        $user->requestResetPassword($token, $date);

        $this->expectErrorMessage("Resetting is already requested");
        $user->requestResetPassword($token, $date);
    }

    public function testExpired(): void
    {
        $user = (new UserBuilder())->active()->build();

        $date = new DateTimeImmutable();
        $token = $this->createToken($date->modify("+1 hour"));
        $user->requestResetPassword($token, $date);

        $newDate = new DateTimeImmutable("+2 hours");
        $newToken = $this->createToken($newDate->modify("+1 hour"));
        $user->requestResetPassword($newToken, $newDate);

        self::assertEquals($newToken, $user->getResetPasswordToken());
    }

    public function testNotActive(): void
    {
        $user = (new UserBuilder())->build();

        $date = new DateTimeImmutable();
        $token = $this->createToken($date->modify("+1 hour"));

        $this->expectErrorMessage("User is not active");
        $user->requestResetPassword($token, $date);
    }

    public function createToken(DateTimeImmutable $date): Token
    {
        return new Token(Uuid::uuid4()->toString(), $date);
    }
}
