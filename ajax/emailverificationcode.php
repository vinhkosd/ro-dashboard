<?php
include __DIR__.'/../app/index.php';
use Models\EmailVerificationCode;
validateLogin(true, false);//check account login
echo(json_encode(EmailVerificationCode::get())) ;
?>