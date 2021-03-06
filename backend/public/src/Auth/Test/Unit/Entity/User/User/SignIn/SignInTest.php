<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User\User\SignIn;

use App\Auth\Service\PasswordHasher;
use App\Auth\Test\Builder\UserBuilder;
use PHPUnit\Framework\TestCase;

use function var_dump;

class SignInTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->active()->build();

        $user->passwordValidate('hash', $this->createHasher(true));
    }
    public function testException(): void
    {
        $user = (new UserBuilder())->active()->build();

        $this->expectExceptionMessage("Incorrect current password.");
        $user->passwordValidate('not-hash', $this->createHasher(false));
    }

    private function createHasher(bool $valid): PasswordHasher
    {
        $hasher = $this->createStub(PasswordHasher::class);
        $hasher->method('validate')->willReturn($valid);
        return $hasher;
    }
}
