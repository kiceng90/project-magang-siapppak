<?php

namespace App\Enums;

use App\Cores\EnumCore;

class ClientTypeEnum extends EnumCore{
    const FROM_MASTER_KLIEN = 1;
    const FROM_NEW_KLIEN = 2;
    const FROM_NEW_PELAPOR = 3;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::FROM_MASTER_KLIEN => "Klien dari Yang Sudah Terdaftar",
            self::FROM_NEW_KLIEN => "Klien dari Input Pengaduan Baru (Bukan Pelapor)",
            self::FROM_NEW_PELAPOR => "Klien dari Input Pengaduan Baru (Sebagai Pelapor)",
        };
    }
}