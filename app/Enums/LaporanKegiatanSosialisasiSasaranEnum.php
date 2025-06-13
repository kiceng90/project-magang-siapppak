<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LaporanKegiatanSosialisasiSasaranEnum extends EnumCore
{
  const PAUD = 1;
  const SD = 2;
  const SMP = 3;
  const SMA = 4;
  const TPQ = 5;
  const KARTAR = 6;
  const WARGA = 7;
  const LAINNYA = 8;

  public static function label($value)
  {
    return match (intval($value)) {
      self::PAUD => "PAUD/KB/RA/TK/Sederajat",
      self::SD => "SD/MI/Sederajat",
      self::SMP => "SMP/MTS/Sederajat",
      self::SMA => "SMA/SMK/MA/Sederajat",
      self::TPQ => "TPQ/Sederajat",
      self::KARTAR => "Kartar",
      self::WARGA => "Warga",
      self::LAINNYA => "Lainnya",
    };
  }
}
