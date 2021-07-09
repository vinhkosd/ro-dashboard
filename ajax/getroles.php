<?php
include __DIR__.'/../app/index.php';
use Illuminate\Database\Capsule\Manager as DB;
use Models\CharBase;
use Carbon\Carbon;
validateLogin(true, false);//check account login
header('Content-Type: application/json');

$charBase = CharBase::query();
$accId = is_numeric($_GET['accid']) ? $_GET['accid'] : 0;
$charBase->where('accid', $accId);

$column = [
    'zoneid',
    'accid',
    'maincharid'
];

echo(json_encode($charBase->get($column)));
?>