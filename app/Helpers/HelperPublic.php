<?php

namespace App\Helpers;

class HelperPublic
{
    public static $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
    public static $romawiBulan = array(
        "", 
        "I" => 1,
        "II" => 2,
        "III" => 3, 
        "IV" => 4, 
        "V" => 5,
        "VI" => 6,
        "VII" => 7,
        "VIII" => 8,
        "IX" => 9,
        "X" => 10, 
        "XI" => 11,
        "XII" => 12,
    );

    public static function helpResponse($code, $data = NULL, $msg = '', $status = '', $request = NULL)
    {
        switch ($code) {
            case '200':
                $s = 'OK';
                $m = 'Sukses';
                break;
            case '201':
                $s = 'Created';
                $m = 'Data berhasil dibuat';
                break;
            case '202':
                $s = 'Saved';
                $m = 'Data berhasil disimpan';
                break;
            case '204':
                $s = 'No Content';
                $m = 'Data tidak ditemukan';
                break;
            case '304':
                $s = 'Not Modified';
                $m = 'Data gagal disimpan';
                break;
            case '400':
                $s = 'Bad Request';
                $m = 'Fungsi tidak ditemukan';
                break;
            case '401':
                $s = 'Unauthorized';
                $m = 'Silahkan login terlebih dahulu';
                break;
            case '402':
                $s = 'Payment Needed';
                $m = 'User harus melakukan pembayaran terlebih dahulu';
                break;
            case '403':
                $s = 'Forbidden';
                $m = 'Anda tidak dapat mengakses halaman ini, silahkan hubungi Administrator';
                break;
            case '404':
                $s = 'Not Found';
                $m = 'Halaman tidak ditemukan';
                break;
            case '405':
                $s = 'Method Not Allowed';
                $m = 'Metode request tidak diizinkan';
                break;
            case '414':
                $s = 'Request URI Too Long';
                $m = 'Data yang dikirim terlalu panjang';
                break;
            case '422':
                $s = 'Unprocessable Entity';
                $m = 'Data yang Anda inputkan tidak sesuai ketentuan';
                break;
            case '500':
                $s = 'Internal Server Error';
                $m = 'Maaf, terjadi kesalahan dalam mengolah data';
                break;
            case '502':
                $s = 'Bad Gateway';
                $m = 'Tidak dapat terhubung ke server';
                break;
            case '503':
                $s = 'Service Unavailable';
                $m = 'Server tidak dapat diakses';
                break;
            case '504':
                $s = 'Gateway Timeout';
                $m = 'Server tidak merespon';
                break;
            default:
                $s = 'Undefined';
                $m = 'Undefined';
                break;
        }

        $status = ($status != '') ? $status : $s;
        $msg = ($msg != '') ? $msg : $m;
        return [
            'status' => [
                'code' => $code,
                'message' => $msg
            ],
            'data' => $data,
            'request' => $request,
        ];
    }
    
    public static function arrayToCollection($array)
    {
        return collect($array)->map(function ($item) {
            return is_array($item) ? HelperPublic::arrayToCollection($item) : $item;
        });
    }

    public static function normalizePhoneNumber($phone)
    {
        //Terlebih dahulu kita trim dl
        $phone = trim($phone);
        //bersihkan dari karakter yang tidak perlu
        $phone = strip_tags($phone);
        // Berishkan dari spasi
        $phone = str_replace(" ", "", $phone);
        // bersihkan dari bentuk seperti  (022) 66677788
        $phone = str_replace("(", "", $phone);
        // bersihkan dari format yang ada titik seperti 0811.222.333.4
        $phone = str_replace(".", "", $phone);

        //cek apakah mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($phone))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($phone), 0, 3) == '+62') {
                $phone = trim($phone);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr($phone, 0, 1) == '0') {
                $phone = '+62' . substr($phone, 1);
            }
        }
        return $phone;
    }
}
