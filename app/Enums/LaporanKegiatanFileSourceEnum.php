<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LaporanKegiatanFileSourceEnum extends EnumCore
{
    const KONSELING = 1;
    const SOSIALISASI = 2;
    const RAPAT = 3;
    const PIKET = 4;
    const PUBLIKASI_KIE = 5;

    public static function label($value)
    {
        return match (intval($value)) {
            self::KONSELING => "Konseling",
            self::SOSIALISASI => "Sosialisasi",
            self::RAPAT => "Rapat",
            self::PIKET => "Piket",
            self::PUBLIKASI_KIE => "Publikasi_KIE"
        };
    }
}
