<?php

namespace App\Enums;

class CourseTypeEnum
{
    const TEXT = 'text';
    const VIDEO = 'video';

    public static function getValues()
    {
        return [
            self::TEXT,
            self::VIDEO,
        ];
    }
}
