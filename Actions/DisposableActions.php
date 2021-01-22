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
        $result = [];

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
            return $result;
        }
        if ($res["status"] === "success") {
            $resCountry = $res["data"]["country"];
            $resService = $res["data"]["service"];
            $price = $res["data"]["phone"]["price"];

            $result = array(
                "status" => true,
                "country" => $resCountry,
                "service" => $resService,
                "price" => $price
            );
        }
        return $result;
    }

    public function order(array $options): array
    {
        $result = [];

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
            return $result;
        }
        if ($res["status"] === "success") {
            $oldBalance = $res["data"]["old_balance"]; // float
            $newBalance = $res["data"]["new_balance"]; // float
            $number = $res["data"]["phone"]["number"]; // string
            $numberID = $res["data"]["phone"]["id"]; // string

            $result = array(
                "status" => true,
                "oldBalance" => $oldBalance,
                "newBalance" => $newBalance,
                "number" => $number,
                "numberID" => $numberID
            );
        }
        return $result;
    }

    public function cancel(array $options): array
    {
        $result = [];

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
            return $result;
        }
        if ($res["status"] === "success") {
            $oldBalance = $res["data"]["old_balance"]; // float
            $newBalance = $res["data"]["new_balance"]; // float

            $result = array(
                "status" => true,
                "oldBalance" => $oldBalance,
                "newBalance" => $newBalance
            );
        }
        return $result;
    }

    public function update(array $options): array
    {
        $result = [];

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
            return $result;
        }
        if ($res["status"] === "success") {
            $oldStatus = $res["data"]["old_status"]; // string
            $newStatus = $res["data"]["new_status"]; // string
            $numberID = $res["data"]["id"]; // string

            $result = array(
                "status" => true,
                "oldStatus" => $oldStatus,
                "newStatus" => $newStatus,
                "numberID" => $numberID
            );
        }
        return $result;
    }

    public function check(array $options): array
    {
        $result = [];

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
            return $result;
        }
        if ($res["status"] === "success") {
            $sms = $res["data"]["sms"]; // string
            $numberID = $res["data"]["id"]; // string

            $result = array(
                "status" => true,
                "sms" => $sms,
                "numberID" => $numberID
            );
        }
        return $result;
    }
}