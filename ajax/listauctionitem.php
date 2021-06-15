<?php
include __DIR__.'/../app/index.php';
use Models\AuctionCanSignup;
use Models\ItemList;
validateLogin(true, false);//check account login
$listAuctions = AuctionCanSignup::get()->keyBy('itemid');
$listItemName = ItemList::get()->keyBy('itemid');
foreach ($listAuctions as $key => $value) {
    $value['name_en'] = !empty($listItemName[$key]) ? $listItemName[$key]['name_en'] : '';
}

$outputValues = [
    'itemid' => $listAuctions->values(),
    'itemname' => $listItemName
];

echo(json_encode($outputValues));
// echo(json_encode(AuctionCanSignup::get()));
?>