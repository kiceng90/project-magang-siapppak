<?php

namespace App\Enums;

use App\Cores\EnumCore;

class MahasiswaStatusEnum extends EnumCore{
    const ONDUTY = 1;
    const NONACTIVE = 2;
    const OFFDUTY = 3;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::ONDUTY => "Aktif Bertugas",
            self::NONACTIVE => "Tidak Aktif",
            self::OFFDUTY => "Belum Bertugas"
        };
    }
}