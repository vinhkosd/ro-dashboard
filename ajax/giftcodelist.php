<?php
include __DIR__.'/../app/index.php';
use Models\GiftCode;
validateLogin(true, false);//check account login
const CHUA_SU_DUNG = 2;
const DA_SU_DUNG = 1;

$columns = [];

$giftCodeQuery = GiftCode::query();
$giftID = isset($_POST['GiftID']) ? intval($_POST['GiftID']) : 0;
$giftUsed = isset($_POST['GiftUsed']) ? intval($_POST['GiftUsed']) : 0;
if($giftID > 0) {
    $giftCodeQuery->where('giftcode.GiftID', $giftID);
}

if($giftUsed > 0) {
    $giftCodeQuery->leftJoin('giftcode_logs', 'giftcode_logs.code' , '=' ,'giftcode.Code');
    if($giftUsed == DA_SU_DUNG){
    $giftCodeQuery->whereNotNull('giftcode_logs.charid');
    } else {
        $giftCodeQuery->whereNull('giftcode_logs.charid');
    }
    
    $columns = ['giftcode.*'];
}
if(count($columns) > 0) {
    echo(json_encode($giftCodeQuery->get($columns)));
}
else {
    echo(json_encode($giftCodeQuery->get()));
}

?>