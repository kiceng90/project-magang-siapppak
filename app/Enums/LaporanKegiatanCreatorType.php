<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LaporanKegiatanCreatorType extends EnumCore{
    const MAHASISWA = 1;
    const FASILITATOR = 2;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::MAHASISWA => "Mahasiswa",
            self::FASILITATOR => "Fasilitator"
        };
    }
}