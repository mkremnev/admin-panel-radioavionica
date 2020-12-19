<?php

declare(strict_types=1);

namespace App\Auth\Service;

use App\Auth\Entity\User\Token;
use DateInterval;
use DateTimeImmutable;
use Ramsey\Uuid\Nonstandard\Uuid;

class Tokenizer
{
    private DateInterval $interval;
    public function __construct(DateInterval $interval)
    {
        $this->interval = $interval;
    }
    public function generate(DateTimeImmutable $date): Token
    {
        $uuid = Uuid::uuid4()->toString();
        return new Token($uuid, $date->add($this->interval));
    }
}
