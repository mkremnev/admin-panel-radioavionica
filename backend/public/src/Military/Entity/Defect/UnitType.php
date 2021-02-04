<?php

declare(strict_types=1);

namespace App\Military\Entity\Defect;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class UnitType extends StringType
{
    public const NAME = 'military_defect_unit';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Unit ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Unit((string)$value) : null;
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
