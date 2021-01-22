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
            "auth" => array(
                "username" => $this->auth["user"],
                "password" => $this->auth["pass"]
            )
        );
        $res = HttpClient::request("balance", $data);
        if (!isset($res["status"], $res["data"])) {
            return $value;
        }
        if ($res["status"] === "success") {
            $value = $res["data"]["balance"];
        }
        return $value;
    }
}