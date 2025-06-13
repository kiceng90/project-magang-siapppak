<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LangEnum extends EnumCore{
    const LISAN = 1;
    const ISYARAT = 2;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::LISAN => "Bahasa Lisan",
            self::ISYARAT => "Bahasa Isyarat"
        };
    }
}