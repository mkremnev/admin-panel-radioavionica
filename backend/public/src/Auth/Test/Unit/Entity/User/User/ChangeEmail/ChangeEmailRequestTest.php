<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User\User\ChangeEmail;

use Ramsey\Uuid\Uuid;
use DateTimeImmutable;
use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;
use PHPUnit\Framework\TestCase;
use App\Auth\Test\Builder\UserBuilder;

class ChangeEmailRequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())
            ->withEmail($old = new Email('old@email.ru'))
            ->active()
            ->build();

        $now = new DateTimeImmutable();

        $token = $this->createToken($now->modify('+1 day'));

        $user->changeEmailRequest(
            $token,
            $now,
            $new = new Email('new@email.ru')
        );

        self::assertEquals($token, $user->getEmailChangeToken());
        self::assertEquals($old, $user->getEmail());
        self::assertEquals($new, $user->getNewEmail());
    }

    public function testSame(): void
    {
        $user = (new UserBuilder())
            ->withEmail($old =new Email('old@email.ru'))
            ->active()
            ->build();

        $now = new DateTimeImmutable();

        $token = $this->createToken($now->modify('+1 day'));

        $this->expectExceptionMessage("Email is already same");
        $user->changeEmailRequest(
            $token,
            $now,
            $old
        );
    }

    public function testAlready(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();

        $now = new DateTimeImmutable();

        $token = $this->createToken($now->modify('+1 day'));
        $user->changeEmailRequest(
            $token,
            $now,
            $new = new Email('new@email.ru')
        );

        $this->expectExceptionMessage("Changing is already requested");
        $user->changeEmailRequest(
            $token,
            $now,
            $new
        );
    }

    public function testExpired(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 hour'));
        $user->changeEmailRequest(
            $token,
            $now,
            $new = new Email('temp@email.ru')
        );

        $newDate = $now->modify("+2 hours");
        $newToken = $this->createToken($newDate->modify('+1 hour'));
        $user->changeEmailRequest(
            $newToken,
            $newDate,
            $newEmail = new Email('temp@email.ru')
        );

        self::assertEquals($newToken, $user->getEmailChangeToken());
        self::assertEquals($newEmail, $user->getNewEmail());
    }

    private function createToken(DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date
        );
    }
}
