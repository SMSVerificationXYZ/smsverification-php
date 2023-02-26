<?php

namespace SMSVerification\Actions\SenderActions;

use SMSVerification\HttpClient\HttpClient;
use SMSVerification\Misc\Categories;
use SMSVerification\Misc\ResponseStatus;
use SMSVerification\Models\Sender\Contact;
use SMSVerification\Models\Sender\Order;

class SenderActions
{
    public function addContact(string $name, string $number): ?Contact
    {
        $res = HttpClient::request(Categories::SENDER,
            '/contact',
            ["data" => ["name" => $name,
                "number" => $number]],
            "POST");
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["contact"])) {
            return null;
        }
        $contact = $res["data"]["contact"];
        return new Contact($contact["id"], $contact["name"], $contact["number"], $contact["created_at"]);
    }

    public function getContacts(): ?array
    {
        $a = [];
        $res = HttpClient::request(Categories::SENDER, '/contacts');
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["contacts"])) {
            return null;
        }
        $contacts = $res["data"]["contacts"];
        foreach ($contacts as $contact) {
            if (!is_array($contact)) {
                continue;
            }
            $a[] = new Contact($contact["id"], $contact["name"], $contact["number"], $contact["created_at"]);
        }
        return $a;
    }

    public function getContact(int $contactId): ?Contact
    {
        $res = HttpClient::request(Categories::SENDER, "/contacts/{$contactId}");
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["contact"])) {
            return null;
        }
        $contact = $res["data"]["contact"];
        return new Contact($contact["id"], $contact["name"], $contact["number"], $contact["created_at"]);
    }

    public function deleteContact(int $contactId): bool|array
    {
        $res = HttpClient::request(Categories::SENDER,
            "/contact/{$contactId}/delete",
            [],
            "POST");
        if (!isset($res["status"])) {
            return false;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        return $res["status"] === ResponseStatus::SUCCESS;
    }

    public function editContactName(int $contactId, string $name): ?array
    {
        $res = HttpClient::request(Categories::SENDER,
            "/contact/{$contactId}/edit",
            ["data" => ["name" => $name]],
            "PUT");
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["new_name"])) {
            return null;
        }
        return [
            "old_name" => $res["data"]["old_name"],
            "new_name" => $res["data"]["new_name"]
        ];
    }

    public function editContactNumber(int $contactId, string $number): ?array
    {
        $res = HttpClient::request(Categories::SENDER,
            "/contact/{$contactId}/edit",
            ["data" => ["number" => $number]],
            "PUT");
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["new_number"])) {
            return null;
        }
        return [
            "old_number" => $res["data"]["old_number"],
            "new_number" => $res["data"]["new_number"]
        ];
    }

    public function order(string $from, array|string $rcpt, string $message): ?array {
        $res = HttpClient::request(Categories::SENDER, "/order", [
            "data" => [
                "from" => $from,
                "rcpt" => $rcpt,
                "message" => $message
            ]
        ], "POST");
        if (!isset($res["status"])) {
            return null;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (!isset($res["data"]["message"])) {
            return null;
        }
        return ["message" => $res["data"]["message"]];
    }

    public function getOrders(): ?array {
        $a = [];
        $res = HttpClient::request(Categories::SENDER, "/orders");
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
            $a[] = new Order($order["id"], $order["recipient"], $order["message"], $order["price"], $order["date"], $order["status"]);
        }
        return $a;
    }

    public function getOrder(int $orderId): ?Order {
        $res = HttpClient::request(Categories::SENDER, "/orders/{$orderId}");
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
        return new Order($order["id"], $order["recipient"], $order["message"], $order["price"], $order["date"], $order["status"]);
    }
}