<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User\User\ChangePassword;

use App\Auth\Service\PasswordHasher;
use App\Auth\Test\Builder\UserBuilder;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

class ChangePasswordTest extends TestCase
{
    public function testSuccess(): void
    {
        $user =(new UserBuilder())->active()->build();

        $hasher = $this->createHasher(true, $hash = 'new-hash');

        $user->changePassword(
            'old-password',
            'new-password',
            $hasher
        );

        self::assertEquals($hash, $user->getHashPassword());
    }

    public function testInvalidCurrentPassword(): void
    {
        $user =(new UserBuilder())->active()->build();

        $hasher = $this->createHasher(false, $hash = 'new-hash');

        $this->expectExceptionMessage('Incorrect current password');
        $user->changePassword(
            'wrong-old-password',
            'new-password',
            $hasher
        );
    }

    private function createHasher(bool $valid, string $value): PasswordHasher
    {
        $hasher = $this->createStub(PasswordHasher::class);
        $hasher->method('validate')->willReturn($valid);
        $hasher->method('hash')->willReturn($value);
        return $hasher;
    }
}
