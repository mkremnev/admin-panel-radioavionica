<?php
declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User;

use App\Auth\Entity\User\Email;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */

class EmailtTest extends TestCase
{
    public function testSucces(): void
    {
        $email = new Email($value = 'test@test.ru');
        Assert::assertEquals($value, $email->getValue());
    }

    public function testEquals(): void
    {
        $email = new Email('Test@teSt.RU');
        Assert::assertEquals('test@test.ru', $email->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('not-email');

    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('');
    }
}
