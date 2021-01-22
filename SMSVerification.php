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
    private string $username;
    private string $password;

    private UserActions $userActions;
    private DisposableActions $disposableActions;

    public function __construct(string $username, string $password)
    {
        // Auth
        $this->username = $username;
        $this->password = $password;

        // Objects
        $this->userActions = new UserActions($this->getAuthDetails());
        $this->disposableActions = new DisposableActions($this->getAuthDetails());
    }

    public function getAuthDetails(): array
    {
        return array(
            "user" => $this->username,
            "pass" => $this->password
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