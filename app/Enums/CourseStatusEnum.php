<?php

namespace App\Enums;

class CourseStatusEnum
{
    const ACTIVE = 'active';
    const ARCHIVED = 'archived';
    const DRAFT = 'draft';
    const INACTIVE = 'inactive';

    public static function getValues()
    {
        return [
            self::ACTIVE,
            self::ARCHIVED,
            self::DRAFT,
            self::INACTIVE,
        ];
    }
}
