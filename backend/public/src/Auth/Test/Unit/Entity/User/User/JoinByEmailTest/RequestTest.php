<?php
declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User\User\JoinByEmailTest;

use DateTimeImmutable;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\User;
use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

/**
 * @covers User
 */

class RequestTest extends TestCase
{
    public function testSucces(): void
    {
        $user = new User(
            $id = Id::generate(),
            $date = new DateTimeImmutable(),
            $email = new Email('test@test.ru'),
            $hash = 'hash',
            $token = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable())
        );

        self::assertEquals($id, $user->getId());
        self::assertEquals($date, $user->getDate());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($hash, $user->getHashPassword());
        self::assertEquals($token, $user->getToken());
    }
}
