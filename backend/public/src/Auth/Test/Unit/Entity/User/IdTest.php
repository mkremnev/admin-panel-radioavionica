<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User;

use App\Auth\Entity\User\Id;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

/**
 * @covers Id
 */

class IdTest extends TestCase
{
    public function testSucces(): void
    {
        $id = new Id($value = Uuid::uuid4()->toString());
        Assert::assertEquals($value, $id->getValue());
    }

    public function testEquals(): void
    {
        $uuid = Uuid::uuid4()->toString();
        $id = new Id(mb_strtolower($uuid));
        Assert::assertEquals($uuid, $id->getValue());
    }

    public function testGenerate(): void
    {
        $id = Id::generate();
        self::assertNotEmpty($id->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Id('1234');
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Id('');
    }
}
