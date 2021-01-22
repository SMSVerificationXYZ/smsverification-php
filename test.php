<?php


use SMSVerification\SMSVerification;

require_once "SMSVerification.php";

$api = new SMSVerification("user","pass");

$balance = $api->getUserActions()->getBalance(); // getting the current balance and storing it as float
$numberPrice = $api->getDisposableActions()->getPrice(["country" => "Russia", "service" => "ProtonMail"]); // getting the price and storing it as array
$order = $api->getDisposableActions()->order(["country" => "Russia", "service" => "ProtonMail"]); // placing a new order and storing it as array.
