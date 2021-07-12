<?php
include __DIR__.'/../app/index.php';
use Models\GiftCode;
validateLogin(true, false);//check account login

$giftCodeQuery = GiftCode::query();
$giftCodeQuery->groupBy('GiftID', 'Title');
echo(json_encode($giftCodeQuery->get(['GiftID', 'Title']))) ;
?>