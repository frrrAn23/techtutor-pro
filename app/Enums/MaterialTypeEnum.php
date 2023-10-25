<?php

namespace App\Enums;

class MaterialTypeEnum
{
    const LESSON = 'lesson';
    const QUIZ = 'quiz';

    public static function getValues()
    {
        return [
            self::LESSON,
            self::QUIZ,
        ];
    }
}
