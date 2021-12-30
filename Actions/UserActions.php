<?php


namespace SMSVerification\Actions\UserActions;


use SMSVerification\HttpClient\HttpClient;

class UserActions
{
    private array $auth;

    public function __construct(array $auth)
    {
        $this->auth = $auth;
    }

    public function getBalance(): float
    {
        $value = -1;
        $data = array(
            "token" => $this->auth["apiKey"],
            "data" => []
        );
        $res = HttpClient::request("balance", $data);
        if (!isset($res["status"], $res["data"])) {
            var_dump($res);
            return $value;
        }
        if ($res["status"] === "success") {
            $value = $res["data"]["balance"];
        }
        return $value;
    }
}