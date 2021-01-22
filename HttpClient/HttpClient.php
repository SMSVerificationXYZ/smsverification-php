<?php

namespace SMSVerification\HttpClient;

use SMSVerification\SMSVerification;

class HttpClient
{
    public static function request(string $dest, array $data, string $method = "GET"): array
    {
        $root = SMSVerification::getRootUrl();

        $payload = json_encode($data);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "{$root}{$dest}",
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload)
            )
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }
}