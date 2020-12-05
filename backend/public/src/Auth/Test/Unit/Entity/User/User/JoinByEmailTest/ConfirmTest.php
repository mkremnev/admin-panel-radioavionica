<?php
declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User\User\JoinByEmailTest;

use App\Auth\Entity\User\Token;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;
use App\Auth\Test\Builder\UserBuilder;
use DateTimeImmutable;

/**
 * @covers \App\Auth\Entity\User\User
 */
class ConfirmTest extends TestCase
{
    public function testSucces(): void
    {
        $user = (new UserBuilder())->withJoinConfirmToken(
            $token = $this->createToken()
        )->build();

        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());

        $user->confirmJoin($token->getValue(), $token->getExpires()->modify("-1 day"));

        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());

        self::assertNull($user->getJoinConfirmToken());
    }

    public function testWrong(): void
    {
        $user = (new UserBuilder())->withJoinConfirmToken(
            $token = $this->createToken()
        )->build();

        $this->expectExceptionMessage("Token is invalid");

        $user->confirmJoin(Uuid::uuid4()->toString(), $token->getExpires()->modify("-1 day"));
    }

    public function testExpires(): void
    {
        $user = (new UserBuilder())->withJoinConfirmToken(
            $token = $this->createToken()
        )->build();

        $this->expectExceptionMessage("Token is expired");

        $user->confirmJoin($token->getValue(), $token->getExpires()->modify("+1 day"));
    }

    public function testAlready(): void
    {
        $token = $this->createToken();
        $user = (new UserBuilder())->withJoinConfirmToken($token)->active()->build();

        $this->expectExceptionMessage("Confirmation is not required");

        $user->confirmJoin($token->getValue(), $token->getExpires("-1 day"));
    }

    private function createToken(): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            new DateTimeImmutable("+1 day")
        );
    }
}
