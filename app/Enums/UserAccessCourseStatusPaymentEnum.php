<?php

namespace App\Enums;

class UserAccessCourseStatusPaymentEnum
{
    const PENDING = 'pending';
    const PAID = 'paid';
    const EXPIRED = 'expired';

    public static function getValues()
    {
        return [
            self::PENDING,
            self::PAID,
            self::EXPIRED,
        ];
    }
}
