<?php

namespace App\Enums;

use App\Cores\EnumCore;

class DayEnum extends EnumCore{
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;

    public static function label($value)
    {
        return match($value)
        {
            self::MONDAY => "Senin",
            self::TUESDAY => "Selasa",
            self::WEDNESDAY => "Rabu",
            self::THURSDAY => "Kamis",
            self::FRIDAY => "Jumat",
        };
    }
}