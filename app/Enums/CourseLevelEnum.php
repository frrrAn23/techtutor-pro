<?php

namespace App\Enums;

class CourseLevelEnum
{
    const BEGINNER = 0;
    const INTERMEDIATE = 1;
    const ADVANCED = 2;

    public static function getValues()
    {
        return [
            self::BEGINNER,
            self::INTERMEDIATE,
            self::ADVANCED,
        ];
    }

    public static function getValuesAndLabels()
    {
        return [
            self::BEGINNER => 'Pemula',
            self::INTERMEDIATE => 'Menengah',
            self::ADVANCED => 'Mahir',
        ];
    }

    public static function getLabel($value)
    {
        return self::getValuesAndLabels()[$value];
    }
}
