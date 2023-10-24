<?php

namespace App\Enums;

class LastEducationEnum
{
    const ELEMENTARY_SCHOOL = 'SD';
    const JUNIOR_HIGH_SCHOOL = 'SMP';
    const SENIOR_HIGH_SCHOOL = 'SMA';
    const VOCATIONAL_HIGH_SCHOOL = 'SMK';
    const DIPLOMA = 'D1';
    const ASSOCIATE = 'D2';
    const DIPLOMA_THREE = 'D3';
    const BACHELOR = 'S1';
    const MASTER = 'S2';
    const DOCTORATE = 'S3';

    public static function getAll()
    {
        return [
            self::ELEMENTARY_SCHOOL,
            self::JUNIOR_HIGH_SCHOOL,
            self::SENIOR_HIGH_SCHOOL,
            self::VOCATIONAL_HIGH_SCHOOL,
            self::DIPLOMA,
            self::ASSOCIATE,
            self::DIPLOMA_THREE,
            self::BACHELOR,
            self::MASTER,
            self::DOCTORATE,
        ];
    }
}
