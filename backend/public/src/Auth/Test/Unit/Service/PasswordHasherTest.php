<?php
declare(strict_types=1);

namespace App\Auth\Test\Unit\Service;

use PHPUnit\Framework\TestCase;
use App\Auth\Service\PasswordHasher;
use InvalidArgumentException;

/**
 * @covers PasswordHasher
 */

class PasswordHasherTest extends TestCase
{
    public function testHash(): void
    {
        $hasher = new PasswordHasher(16);
        $hash = $hasher->hash($password = 'hash');
        self::assertNotEmpty($hash);
        self::assertNotEquals($password, $hash);
    }

    public function testHashEmpty(): void
    {
        $hasher = new PasswordHasher(16);

        $this->expectException(InvalidArgumentException::class);
        $hasher->hash('');
    }

    public function testHashValidate(): void
    {
        $hasher = new PasswordHasher(16);
        $hash = $hasher->hash($password = 'hash');
        self::assertTrue($hasher->validate($password, $hash));
        self::assertFalse($hasher->validate('incorect-password', $hash));
    }
}
