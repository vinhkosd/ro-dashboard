<?php
include __DIR__.'/../app/index.php';
use Models\AccountLogs;
validateLogin(true, false);//check account login
echo(json_encode(AccountLogs::get())) ;
?>