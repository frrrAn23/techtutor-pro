<?php

namespace App\Enums;

class UserAccessCourseStatusEnum
{
    const PENDING = 'pending';
    const UNPAID = 'unpaid';
    const ACTIVE = 'active';
    const SUSPENDED = 'suspended';

    public static function getValues()
    {
        return [
            self::PENDING,
            self::UNPAID,
            self::ACTIVE,
            self::SUSPENDED,
        ];
    }
}
