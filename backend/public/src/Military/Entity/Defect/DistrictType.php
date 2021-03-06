<?php

declare(strict_types=1);

namespace App\Military\Entity\Defect;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class DistrictType extends StringType
{
    public const NAME = 'military_defect_district';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof District ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new District((string)$value) : null;
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
