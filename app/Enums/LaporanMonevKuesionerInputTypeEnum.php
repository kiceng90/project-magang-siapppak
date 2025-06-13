<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LaporanMonevKuesionerInputTypeEnum extends EnumCore{
    const RADIO = 1;
    const TEXT = 2;
    const FILE = 3;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::RADIO => "radio",
            self::TEXT => "text",
            self::FILE => "file"
        };
    }
}