<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LaporanKegiatanKonselingTypeEnum extends EnumCore{
    const LIGHT = 1;
    const MEDIUM = 2;
    const HEAVY = 3;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::LIGHT => "Ringan",
            self::MEDIUM => "Sedang",
            self::HEAVY => "Berat"
        };
    }

    public static function description($value)
    {
        return match(intval($value))
        {
            self::LIGHT => "Masalah dapat ditangani di Tingkat RW",
            self::MEDIUM => "Masalah dapat ditangani di Tingkat Kelurahan/Kecamatan",
            self::HEAVY => "Masalah ditangani dan dirujuk ke UPTD PPA/Puspaga Kota"
        };
    }
}