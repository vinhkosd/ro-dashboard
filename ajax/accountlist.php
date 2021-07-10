<?php
include __DIR__.'/../app/index.php';
use Models\Account;
use Carbon\Carbon;
validateLogin(true, false);//check account login

$accountList = Account::get();

echo(json_encode($accountList));
?>