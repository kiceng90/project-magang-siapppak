<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WhatsappTwilioHelper
{
    protected static $sender = "+6285736057993";
    protected static $token = "Basic QUM3NmIzYjgzYzIxZDA0YTc5YjdkNTVlMGNhMTExMzljZTowMDYzMzdkZGU3YmFjNDQxNzQ4MGIwNjYxNWYwYTI5Ng==";

    /**
     * @param array $phones = Nomor whatsapp tujuan. Anda dapat menggunakan prefiks kode negara atau tidak.
     * @param string @message = Pesan teks yang akan dikirim. Format: UTF-8 atau string UTF-16. maksimum karakter adalah 1024.
     * @return array
     */
    public static function send(array $phones = [], string $message = '')
    {
        $result = [];

        foreach ($phones as $key => $phone) {
            $response = Http::asForm()
                ->withHeaders([
                    'Authorization' => self::$token
                ])
                ->post("https://api.twilio.com/2010-04-01/Accounts/AC76b3b83c21d04a79b7d55e0ca11139ce/Messages.json", [
                    'To' => 'whatsapp:'.$phone,
                    'From' => 'whatsapp:'.self::$sender,
                    'Body' => $message
                    // 'Body' => $message
                ]);
    
            $result[$key] = $response->body();
        }

        return $result;
    }
}
