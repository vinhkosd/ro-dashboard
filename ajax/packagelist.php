<?php
include __DIR__.'/../app/index.php';
use Models\TableDeposit;
validateLogin(true, false);//check account login
echo(json_encode(TableDeposit::get())) ;
?>