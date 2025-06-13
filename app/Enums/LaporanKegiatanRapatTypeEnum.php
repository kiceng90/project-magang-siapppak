<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LaporanKegiatanRapatTypeEnum extends EnumCore
{
  const RAPAT = 1;
  const KOORDINASI = 2;
  const KEGIATANLAIN = 3;

  public static function label($value)
  {
    return match (intval($value)) {
      self::RAPAT => "Rapat",
      self::KOORDINASI => "Koordinasi",
      self::KEGIATANLAIN => "Kegiatan Lain",
    };
  }
}
