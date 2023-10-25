<?php

namespace App\Enums;

class MaterialStatusEnum
{
    const ACTIVE = 'active';
    const DRAFT = 'draft';

    public static function getValues()
    {
        return [
            self::ACTIVE,
            self::DRAFT,
        ];
    }
}
