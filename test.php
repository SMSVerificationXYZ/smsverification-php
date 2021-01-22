<?php


use SMSVerification\SMSVerification;

require_once "SMSVerification.php";

$api = new SMSVerification("user","pass");
echo $api->getUserActions()->getBalance(); // getting the current balance and printing it.