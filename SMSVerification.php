<?php


namespace SMSVerification;

require_once "Actions/UserActions.php";
require_once "Actions/DisposableActions.php";
require_once "Actions/RentalActions.php";
require_once "Actions/SenderActions.php";
require_once "HttpClient/HttpClient.php";
require_once "Misc/Categories.php";
require_once "Misc/ResponseStatus.php";
require_once "Models/Rental/Order.php";
require_once "Models/Sender/Order.php";
require_once "Models/Sender/Contact.php";

use SMSVerification\Actions\DisposableActions\DisposableActions;
use SMSVerification\Actions\RentalActions\RentalActions;
use SMSVerification\Actions\SenderActions\SenderActions;
use SMSVerification\Actions\UserActions\UserActions;
use SMSVerification\HttpClient\HttpClient;

class SMSVerification
{
    private const ROOT = "https://smsverification.xyz/api/v2/";
    private UserActions $userActions;
    private DisposableActions $disposableActions;
    private RentalActions $rentalActions;
    private SenderActions $senderActions;

    public function __construct(string $key)
    {
        // Auth
        HttpClient::init($key);

        // Objects
        $this->userActions = new UserActions();
        $this->disposableActions = new DisposableActions();
        $this->rentalActions = new RentalActions();
        $this->senderActions = new SenderActions();
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

    /**
     * @return RentalActions
     */
    public function getRentalActions(): RentalActions
    {
        return $this->rentalActions;
    }

    /**
     * @return SenderActions
     */
    public function getSenderActions(): SenderActions
    {
        return $this->senderActions;
    }
}