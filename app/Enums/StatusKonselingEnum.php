<?php

namespace App\Enums;

use App\Cores\EnumCore;

class StatusKonselingEnum extends EnumCore{
    const PENDING = 1;
    const ACCEPTED = 2;
    const FINISHED_WITH_NOTE = 3;
    const FINISHED_WITHOUT_NOTE = 4;
    const REJECTED = 5;
    const EXPIRED = 6;
    const ABSENT = 7;

    public static function labelStatus($value)
    {
        return match(intval($value))
        {
            self::PENDING => "Belum Disetujui",
            self::ACCEPTED => "Sudah Disetujui",
            self::FINISHED_WITH_NOTE => "Selesai Dengan Rujukan",
            self::FINISHED_WITHOUT_NOTE => "Selesai Tanpa Rujukan",
            self::REJECTED => "Ditolak",
            self::EXPIRED => "Kadaluarsa",
            self::ABSENT => "Tidak Hadir",
        };
    }
    public static function labelKeterangan($value, $note = null)
    {
        return match(intval($value))
        {
            self::PENDING => "Menunggu konfirmasi Konsultan",
            self::ACCEPTED => "Konsultasi dikonfirmasi dan dilaksanakan via Zoom Meeting <br> Link: https://telkomsel.zoom.us/j/7127622420?pwd=bHBoVG9OUGpNQzVtTnQ2Rk1aSTRCdz09 <br> Meeting ID: 712 762 2420 <br> Passcode: puspaga",
            self::FINISHED_WITH_NOTE => "Selesai dengan Rujukan ke Psikolog (" . $note . ")",
            self::FINISHED_WITHOUT_NOTE => "Selesai tanpa Rujukan",
            self::REJECTED => "Ditolak dengan alasan ".$note,
            self::EXPIRED => "Kadaluarsa",
            self::ABSENT => "Tidak hadir",
        };
    }
    public static function labelPesan($value)
    {
        return match(intval($value))
        {
            self::PENDING => "",
            self::ACCEPTED => "Pengajuan Sesi Konseling telah diterima",
            self::FINISHED_WITH_NOTE => "Sesi Konseling telah selesai dengan rujukan",
            self::FINISHED_WITHOUT_NOTE => "Sesi Konseling telah selesai tanpa rujukan",
            self::REJECTED => "Pengajuan Sesi Konseling telah ditolak",
            self::EXPIRED => "Pengajuan Sesi Konseling telah kadaluarsa",
            self::ABSENT => "Klien tidak hadir pada sesi konseling",
        };
    }
}