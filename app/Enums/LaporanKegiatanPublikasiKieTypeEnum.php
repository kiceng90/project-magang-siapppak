<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LaporanKegiatanPublikasiKieTypeEnum extends EnumCore{
    const NARASI = 1;
    const DESAIN = 2;
    const PELIPUTAN = 3;
    const REVISI = 4;
    const PUBLIKASI = 5;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::NARASI => "Pembuatan Narasi / Script",
            self::DESAIN => "Pembuatan Desain / Produksi Video",
            self::PELIPUTAN => "Peliputan",
            self::REVISI => "Revisi Konten",
            self::PUBLIKASI => "Publikasi Konten"
        };
    }
}