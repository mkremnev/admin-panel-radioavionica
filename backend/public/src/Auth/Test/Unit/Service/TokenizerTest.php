<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Service;

use DateInterval;
use DateTimeImmutable;
use App\Auth\Service\Tokenizer;
use PHPUnit\Framework\TestCase;

/**
 * @covers ExpiresTokenizer
 */

class TokenizerTest extends TestCase
{
    public function testSucces(): void
    {
        $interval = new DateInterval('PT1H');
        $date = new DateTimeImmutable();

        $tokenizer = new Tokenizer($interval);

        $token = $tokenizer->generate($date);

        self::assertEquals($date->add($interval), $token->getExpires());
    }
}
