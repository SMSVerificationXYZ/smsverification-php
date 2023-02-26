<?php


namespace SMSVerification\Actions\UserActions;


use SMSVerification\HttpClient\HttpClient;
use SMSVerification\Misc\Categories;
use SMSVerification\Misc\ResponseStatus;

class UserActions
{
    /**
     * Returning current balance of the user.
     * @return array|float Array for errors, float for balance.
     */
    public function getBalance(): array|float
    {
        $balance = -1;
        $res = HttpClient::request(Categories::USER, "/balance");
        if (!isset($res["status"])) {
            return $balance;
        }
        if ($res["status"] === ResponseStatus::ERROR) {
            HttpClient::handleError($res);
        }
        if (isset($res["data"]["balance"])) {
            $balance = $res["data"]["balance"];
        }
        return $balance;
    }
}