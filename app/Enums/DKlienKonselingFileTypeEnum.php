<?php

namespace App\Enums;

use App\Cores\EnumCore;

class DKlienKonselingFileTypeEnum extends EnumCore{
    const FOTO = 1;
    const KTP = 2;
    const TTD = 3;
    const KK = 4;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::FOTO => "Foto",
            self::KTP => "KTP",
            self::TTD => "Tanda Tangan",
            self::KK => "KK",
        };
    }
}