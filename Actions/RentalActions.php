<?php

namespace SMSVerification\Actions\RentalActions;

use SMSVerification\HttpClient\HttpClient;
use SMSVerification\Misc\Categories;
use SMSVerification\Misc\ResponseStatus;
use SMSVerification\Models\Rental\Order;

class RentalActions
{
    /**
     * @param string $country Desired Country
     * @param string $service Desired Service
     * @param int $length Desired rent time (In Hours)
     * @return array|null
     */
    public function getPrice(string $country, string $service, int $length): ?array
    {
        $res = HttpClient::request(Categories::RENTAL, "/price/{$country}/{$service}/{$length}");
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
            "length" => $res["data"]["length"],
            "price" => $res["data"]["phone"]["price"]
        ];
    }

    public function order(string $country, string $service, int $length): ?Order
    {
        $res = HttpClient::request(Categories::RENTAL,
            '/order',
            ["data" => ["country" => $country,
                "service" => $service,
                "length" => $length]],
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
        return new Order($res["data"]["phone"]["id"],
            $res["data"]["phone"]["number"],
            $res["data"]["phone"]["purchased_at"],
            $res["data"]["phone"]["expires_at"],
            $res["data"]["phone"]["can_cancel"],
            $res["data"]["phone"]["expired"],
            []);
    }

    public function getOrders(): ?array
    {
        $a = [];
        $res = HttpClient::request(Categories::RENTAL, '/orders');
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["orders"])) {
            return null;
        }
        $orders = $res["data"]["orders"];
        foreach ($orders as $order) {
            if (!is_array($order)) {
                continue;
            }
            $a[] = new Order($order["id"],
                $order["number"],
                $order["purchased_at"],
                $order["expires_at"],
                $order["can_cancel"],
                $order["expired"],
                $order["messages"]);
        }
        return $a;
    }

    public function getOrder(int $orderId): ?Order
    {
        $res = HttpClient::request(Categories::RENTAL, "/orders/{$orderId}");
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["order"])) {
            return null;
        }
        $order = $res["data"]["order"];
        return new Order($order["id"],
            $order["number"],
            $order["purchased_at"],
            $order["expires_at"],
            $order["can_cancel"],
            $order["expired"],
            $order["messages"]);
    }

    public function cancel(int $orderId): ?array
    {
        $res = HttpClient::request(Categories::RENTAL, "/orders/{$orderId}/cancel", [], 'POST');
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

    public function getMessages(int $orderId): ?array
    {
        $res = HttpClient::request(Categories::RENTAL, "/orders/{$orderId}/refresh", [], 'POST');
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        return $res["data"]["messages"] ?? null;
    }
}