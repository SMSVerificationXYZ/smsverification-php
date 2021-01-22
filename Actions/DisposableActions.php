<?php

namespace SMSVerification\Actions\DisposableActions;

use SMSVerification\HttpClient\HttpClient;

class DisposableActions
{
    private array $auth;

    public function __construct(array $auth)
    {
        $this->auth = $auth;
    }

    public function getPrice(array $options): array
    {
        $country = $options["country"];
        $service = $options["service"];

        $data = array(
            "auth" => array(
                "username" => $this->auth["user"],
                "password" => $this->auth["pass"]
            ),
            "country" => $country,
            "service" => $service
        );

        $res = HttpClient::request("disposable/price", $data);

        if (!isset($res["status"], $res["data"])) {
            return array(
                "status" => false,
                "error_type" => $res["error_type"],
                "content" => $res["content"]
            );
        }
        if ($res["status"] === "error") {
            return array(
                "status" => false,
                "error_type" => $res["error_type"],
                "content" => $res["content"]
            );
        }

        $resCountry = $res["data"]["country"];
        $resService = $res["data"]["service"];
        $price = $res["data"]["phone"]["price"];

        return array(
            "status" => true,
            "country" => $resCountry,
            "service" => $resService,
            "price" => $price
        );
    }

    public function order(array $options): array
    {
        $country = $options["country"];
        $service = $options["service"];

        $data = array(
            "auth" => array(
                "username" => $this->auth["user"],
                "password" => $this->auth["pass"]
            ),
            "country" => $country,
            "service" => $service
        );

        $res = HttpClient::request("disposable", $data, "POST");

        if (!isset($res["status"], $res["data"])) {
            return array(
                "status" => false,
                "error_type" => $res["error_type"],
                "content" => $res["content"]
            );
        }
        if ($res["status"] === "error") {
            return array(
                "status" => false,
                "error_type" => $res["error_type"],
                "content" => $res["content"]
            );
        }

        $oldBalance = $res["data"]["old_balance"]; // float
        $newBalance = $res["data"]["new_balance"]; // float
        $number = $res["data"]["phone"]["number"]; // string
        $numberID = $res["data"]["phone"]["id"]; // string

        return array(
            "status" => true,
            "oldBalance" => $oldBalance,
            "newBalance" => $newBalance,
            "number" => $number,
            "numberID" => $numberID
        );
    }

    public function cancel(array $options): array
    {
        $numberID = $options["numberID"];

        $data = array(
            "auth" => array(
                "username" => $this->auth["user"],
                "password" => $this->auth["pass"]
            ),
            "id" => $numberID
        );

        $res = HttpClient::request("disposable/cancel", $data, "DELETE");

        if (!isset($res["status"], $res["data"])) {
            return array(
                "status" => false,
                "error_type" => $res["error_type"],
                "content" => $res["content"]
            );
        }
        if ($res["status"] === "error") {
            return array(
                "status" => false,
                "error_type" => $res["error_type"],
                "content" => $res["content"]
            );
        }

        $oldBalance = $res["data"]["old_balance"]; // float
        $newBalance = $res["data"]["new_balance"]; // float

        return array(
            "status" => true,
            "oldBalance" => $oldBalance,
            "newBalance" => $newBalance
        );
    }

    public function update(array $options): array
    {
        $numberID = $options["numberID"];

        $data = array(
            "auth" => array(
                "username" => $this->auth["user"],
                "password" => $this->auth["pass"]
            ),
            "id" => $numberID
        );

        $res = HttpClient::request("disposable/sent", $data, "PUT");

        if (!isset($res["status"], $res["data"])) {
            return array(
                "status" => false,
                "error_type" => $res["error_type"],
                "content" => $res["content"]
            );
        }
        if ($res["status"] === "error") {
            return array(
                "status" => false,
                "error_type" => $res["error_type"],
                "content" => $res["content"]
            );
        }

        $oldStatus = $res["data"]["old_status"]; // string
        $newStatus = $res["data"]["new_status"]; // string
        $numberID = $res["data"]["id"]; // string

        return array(
            "status" => true,
            "oldStatus" => $oldStatus,
            "newStatus" => $newStatus,
            "numberID" => $numberID
        );
    }

    public function check(array $options): array
    {
        $numberID = $options["numberID"];

        $data = array(
            "auth" => array(
                "username" => $this->auth["user"],
                "password" => $this->auth["pass"]
            ),
            "id" => $numberID
        );

        $res = HttpClient::request("disposable/check", $data);

        if (!isset($res["status"], $res["data"])) {
            return array(
                "status" => false,
                "error_type" => $res["error_type"],
                "content" => $res["content"]
            );
        }
        if ($res["status"] === "error") {
            return array(
                "status" => false,
                "error_type" => $res["error_type"],
                "content" => $res["content"]
            );
        }


        $sms = $res["data"]["sms"]; // string
        $numberID = $res["data"]["id"]; // string


        return array(
            "status" => true,
            "sms" => $sms,
            "numberID" => $numberID
        );
    }
}