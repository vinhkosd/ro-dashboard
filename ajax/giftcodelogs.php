<?php
include __DIR__.'/../app/index.php';

use Illuminate\Database\Capsule\Manager as DB;
use Models\GiftCodeLogs;
validateLogin(true, false);//check account login
echo(json_encode(GiftCodeLogs::get())) ;
?>