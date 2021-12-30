<?php


namespace SMSVerification;

require_once "Actions/UserActions.php";
require_once "Actions/DisposableActions.php";
require_once "HttpClient/HttpClient.php";

use SMSVerification\Actions\DisposableActions\DisposableActions;
use SMSVerification\Actions\UserActions\UserActions;

class SMSVerification
{
    private const ROOT = "https://smsverification.xyz/api/v2/";
    private string $key;

    private UserActions $userActions;
    private DisposableActions $disposableActions;

    public function __construct(string $key)
    {
        // Auth
        $this->key = $key;

        // Objects
        $this->userActions = new UserActions($this->getAuthDetails());
        $this->disposableActions = new DisposableActions($this->getAuthDetails());
    }

    public function getAuthDetails(): array
    {
        return array(
            "apiKey" => $this->key
        );
    }

    public function getUserActions(): UserActions
    {
        return $this->userActions;
    }

    public function getDisposableActions(): DisposableActions
    {
        return $this->disposableActions;
    }

    public static function getRootUrl(): string
    {
        return self::ROOT;
    }
}