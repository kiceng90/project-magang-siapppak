<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LaporanKegiatanSosialisasiTypeEnum extends EnumCore{
    const PARENTING = 1;
    const SCHOOL = 2;
    const COMMUNITY = 3;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::PARENTING => "Kelas parenting",
            self::SCHOOL => "Puspaga goes to school",
            self::COMMUNITY => "Puspaga goes to community (Arisan / Pengajian / Rapat Pengurus RT/RW / dsb)"
        };
    }
}