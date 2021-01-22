<?php


namespace SMSVerification;


class SMSVerification
{
    private const ROOT = "https://smsverification.xyz/api/v2/";
    private string $username;
    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getAuthDetails(): array{
        return array(
            "user" => $this->username,
            "pass" => $this->password
        );
    }

    public static function getRootUrl(): string{
        return self::ROOT;
    }
}