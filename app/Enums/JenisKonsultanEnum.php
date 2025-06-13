<?php

namespace App\Enums;

use App\Cores\EnumCore;

class JenisKonsultanEnum extends EnumCore
{
    const KONSELOR = 1;
    const PSIKOLOG = 2;

    public static function label($value)
    {
        return match (intval($value)) {
            self::KONSELOR => "Konselor",
            self::PSIKOLOG => "Psikolog"
        };
    }
}
