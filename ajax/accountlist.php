<?php
include __DIR__.'/../app/index.php';
use Models\Account;
validateLogin(true, false);//check account login
echo(json_encode(Account::get())) ;
?>