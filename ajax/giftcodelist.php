<?php
include __DIR__.'/../app/index.php';
use Models\GiftCode;
validateLogin(true, false);//check account login
echo(json_encode(GiftCode::get())) ;
?>