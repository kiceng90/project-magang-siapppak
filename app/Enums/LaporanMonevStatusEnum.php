<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LaporanMonevStatusEnum extends EnumCore{
    const UNVERIFIED = 1;
    const VERIFIED_SUBKOORD = 2;
    const VERIFIED_KABID = 3;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::UNVERIFIED => "Belum Diverifikasi",
            self::VERIFIED_KABID => "Verifikasi Kabid",
            self::VERIFIED_SUBKOORD => "Verifikasi Subkoord"
        };
    }
}