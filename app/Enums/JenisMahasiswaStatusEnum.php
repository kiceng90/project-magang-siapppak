<?php

namespace App\Enums;

use App\Cores\EnumCore;

class JenisMahasiswaStatusEnum extends EnumCore
{
    const S1 = 1;
    const S2 = 2;
    const S3 = 3;
    const ALUMNUS = 4;

    public static function label($value)
    {
        return match (intval($value)) {
            self::S1 => "Mahasiswa S1",
            self::S2 => "Mahasiswa S2",
            self::S3 => "Mahasiswa S3",
            self::ALUMNUS => "Alumni"
        };
    }
}
