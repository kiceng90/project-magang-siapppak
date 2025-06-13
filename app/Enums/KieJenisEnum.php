<?php

namespace App\Enums;

use App\Cores\EnumCore;

class KieJenisEnum extends EnumCore{
    const GAMBAR = 1;
    const VIDEO = 2;
    const PDF = 3;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::GAMBAR => "Gambar",
            self::VIDEO => "Video",
            self::PDF => "PDF"
        };
    }
}