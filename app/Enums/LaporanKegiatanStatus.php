<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LaporanKegiatanStatus extends EnumCore{
    const UNVERIFIED = 1;
    const VERIFIED_KONSELOR = 2;
    const VERIFIED_SUBKOORD = 3;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::UNVERIFIED => "Belum Diverifikasi",
            self::VERIFIED_KONSELOR => "Verifikasi Konselor",
            self::VERIFIED_SUBKOORD => "Verifikasi Subkoord"
        };
    }
}