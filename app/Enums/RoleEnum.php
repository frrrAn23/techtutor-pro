<?php

namespace App\Enums;

class RoleEnum
{
    const STUDENT = 'student';
    const INSTRUCTOR = 'instructor';
    const ADMIN = 'admin';

    public static function getValues()
    {
        return [
            self::STUDENT,
            self::INSTRUCTOR,
            self::ADMIN,
        ];
    }
}
