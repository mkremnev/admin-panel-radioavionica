<?php

declare(strict_types=1);

namespace App\Military\Entity\Units;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class AddressType extends StringType
{
    public const NAME = 'military_unit_address';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Address ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Address((string)$value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
