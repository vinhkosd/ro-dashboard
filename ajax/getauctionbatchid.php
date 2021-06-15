<?php
include __DIR__.'/../app/index.php';
use Models\AuctionConfig;
validateLogin(true, false);//check account login
const STATE_OPEN = 2;
$auctionConfig = AuctionConfig::where('state', STATE_OPEN)->first(['id', 'state', 'end_time']);
echo(json_encode($auctionConfig));
?>