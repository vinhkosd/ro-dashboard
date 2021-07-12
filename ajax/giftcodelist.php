<?php
include __DIR__.'/../app/index.php';
use Models\GiftCode;
validateLogin(true, false);//check account login

$giftCodeQuery = GiftCode::query();
$giftID = isset($_POST['GiftID']) ? intval($_POST['GiftID']) : 0;
if($giftID > 0) {
    $giftCodeQuery->where('GiftID', $giftID);
}
echo(json_encode($giftCodeQuery->get())) ;
?>