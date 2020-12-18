<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User\User\ChangeEmail;

use App\Auth\Entity\User\Email;
use Ramsey\Uuid\Uuid;
use DateTimeImmutable;
use App\Auth\Entity\User\Token;
use PHPUnit\Framework\TestCase;
use App\Auth\Test\Builder\UserBuilder;

class ChangeEmailConfirm extends TestCase
{
    public function testSucces(): void
    {
        $user = (new UserBuilder())->active()->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 day'));

        $user->changeEmailRequest($token, $now, $email = new Email('new@email.ru'));

        self::assertNotNull($user->getEmailChangeToken());

        $user->confirmEmailChange($token->getValue(), $now);

        self::assertNull($user->getEmailChangeToken);
        self::assertEquals($email, $user->getEmail());
    }

    public function testInvalidToken(): void
    {
        $user = (new UserBuilder())->active()->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 day'));
        $user->changeEmailRequest($token, $now, $email = new Email('new@email.ru'));

        $this->expectExceptionMessage("Token is invalid");
        $user->confirmEmailChange('invalid', $now);
    }

    public function testExpiredToken(): void
    {
        $user = (new UserBuilder())->active()->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 day'));
        $user->changeEmailRequest($token, $now, $email = new Email('new@email.ru'));

        $this->expectExceptionMessage("Token is expired");
        $user->confirmEmailChange($token->getValue(), $now->modify("+1 day"));
    }

    public function testNotRequested(): void
    {
        $user = (new UserBuilder())->active()->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 day'));

        $this->expectExceptionMessage("Confirmation is not required");
        $user->confirmEmailChange($token->getValue(), $now);
    }

    private function createToken(DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date
        );
    }
}
