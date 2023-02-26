<?php


namespace SMSVerification\HttpClient;


use SMSVerification\SMSVerification;

class HttpClient
{
    private static string $token;

    public static function init(string $token): void
    {
        self::$token = $token;
    }

    public static function request(string $category, string $dest, array $data = [], string $method = "GET"): array
    {
        $root = SMSVerification::getRootUrl();

        $payload = json_encode($data["data"]);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "{$root}{$category}{$dest}",
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authentication: ' . self::$token,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload)
            )
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    public static function handleError(array $response): array
    {
        return [
            "status" => false,
            "error" => $response["error_type"],
            "content" => $response["content"]
        ];
    }
}