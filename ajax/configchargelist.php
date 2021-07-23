<?php
include __DIR__.'/../app/index.php';
use Models\ChargeConfig;
validateLogin(true, false);//check account login

$columns = [];

$chargeConfig = ChargeConfig::query();

echo(json_encode($chargeConfig->get()));

?>