<?php


namespace SMSVerification\Actions\DisposableActions;


use SMSVerification\HttpClient\HttpClient;
use SMSVerification\Misc\Categories;
use SMSVerification\Misc\ResponseStatus;

class DisposableActions
{
    public function getPrice(string $country, string $service): ?array
    {
        $res = HttpClient::request(Categories::DISPOSABLE,
            "/price/{$country}/{$service}");
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["phone"]["price"])) {
            return null;
        }
        return [
            "country" => $res["data"]["country"],
            "service" => $res["data"]["service"],
            "price" => $res["data"]["phone"]["price"]
        ];
    }
    public function order(string $country, string $service): ?array {
        $res = HttpClient::request(Categories::DISPOSABLE,
            "",
            ["data" => ["country" => $country,
                "service" => $service]],
            "POST");
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["phone"]["number"])) {
            return null;
        }
        return [
            "old_balance" => $res["data"]["old_balance"],
            "new_balance" => $res["data"]["new_balance"],
            "phone" => [
                "number" => $res["data"]["phone"]["number"],
                "id" => $res["data"]["phone"]["id"],
                "price" => $res["data"]["phone"]["price"]
            ]
        ];
    }
    public function sent(string $numberId): ?array {
        $res = HttpClient::request(Categories::DISPOSABLE, "/sent/{$numberId}", [], "PUT");
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["new_status"])) {
            return null;
        }
        return [
            "old_status" => $res["data"]["old_status"],
            "new_status" => $res["data"]["new_status"],
            "number_id" => $res["data"]["id"]
        ];
    }
    public function check(string $numberId): ?array {
        $res = HttpClient::request(Categories::DISPOSABLE, "/check/{$numberId}");
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["sms"])) {
            return null;
        }
        return [
            "number_id" => $res["data"]["id"],
            "sms" => $res["data"]["sms"]
        ];
    }
    public function cancel(string $numberId): ?array {
        $res = HttpClient::request(Categories::DISPOSABLE, "/cancel/{$numberId}", [], "DELETE");
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["new_balance"])) {
            return null;
        }
        return [
            "old_balance" => $res["data"]["old_balance"],
            "new_balance" => $res["data"]["new_balance"]
        ];
    }
}