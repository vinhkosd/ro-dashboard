<?php
include __DIR__.'/../app/index.php';
use Models\AuctionItem;
validateLogin(true, false);//check account login
echo(json_encode(AuctionItem::get()));

?>