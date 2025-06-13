<?php

namespace App\Helpers;

class WhatsappHelper
{
    /**
     * @param array $phones = Nomor whatsapp tujuan. Anda dapat menggunakan prefiks kode negara atau tidak.
     * @param string @message = Pesan teks yang akan dikirim. Format: UTF-8 atau string UTF-16. maksimum karakter adalah 1024.
     * @return JSON
     */
    public static function send($phones = [], $message = '')
    {
        $data = [];
        foreach ($phones as $key => $phone) {
            $data[$key] = [
                'phone' => $phone,
                'message' => $message,
            ];
        }

        $curl = curl_init();
        $token = env('SECURITY_TOKEN_WABLAS');
        $payload = [
            "data" => $data
        ];
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL,  env('DOMAIN_SERVER_WABLAS') . "/api/v2/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;

        /**
         * * Contoh format dari $result
         * 
         * {
         *   "status": true,
         *   "message": "Message is pending and waiting to be processed",
         *   "data": {
         *      "device_id": "A5DOYJ",
         *      "quota": 88,
         *      "messages": [
         *           {
         *               "id": "5be46e84-650c-4ba1-a1a6-5647d358c43a",
         *               "phone": "6281218xxxxxx",
         *               "message": "hello there",
         *               "status": "pending"
         *           },
         *           {
         *       "device_id": "BK4L7G",
         *       "quota": 33,
         *       "message": [
         *           {
         *               "id": "bh765a2e-f0a9-43ac-8f3e-816ec7506781",
         *               "phone": "628122123xxxx",
         *               "message": "test get 2",
         *               "status": "pending"
         *           }
         *       ]
         *   }
         * }
         */
    }
}
