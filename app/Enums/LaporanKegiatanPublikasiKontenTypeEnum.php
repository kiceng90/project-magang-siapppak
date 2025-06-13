<?php

namespace App\Enums;

use App\Cores\EnumCore;

class LaporanKegiatanPublikasiKontenTypeEnum extends EnumCore{
    const ARTIKEL = 1;
    const FOTO = 2;
    const VIDEO = 3;
    
    public static function label($value)
    {
        return match(intval($value))
        {
            self::ARTIKEL => "Artikel / Berita Draft Podcast / Live IG / Webinar",
            self::FOTO => "Foto / Flyer / Brosur / Gambar Edukasi",
            self::VIDEO => "Video / Animasi / Iklan Layanan Masyarakat"
        };
    }
}