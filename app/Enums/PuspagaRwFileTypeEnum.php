<?php

namespace App\Enums;

use App\Cores\EnumCore;

class PuspagaRwFileTypeEnum extends EnumCore{
    const FOTO = 1;
    const SK = 2;
    const KTP = 3;
    const TTD = 4;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::FOTO => "Foto",
            self::SK => "SK",
            self::KTP => "KTP",
            self::TTD => "Tanda Tangan"
        };
    }
}