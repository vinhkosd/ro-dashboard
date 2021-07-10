<?php
include __DIR__.'/../app/index.php';
use Illuminate\Database\Capsule\Manager as DB;
use Models\CharBase;
use Carbon\Carbon;
validateLogin(true, false);//check account login
header('Content-Type: application/json');

$charBase = CharBase::query();
$accId = is_numeric($_GET['id']) ? $_GET['id'] : 0;
$zoneId = is_numeric($_GET['zoneid']) ? $_GET['zoneid'] : 0;

$charBase->where('accid', $accId)->where('zoneid', $zoneId);

$column = [
    'zoneid',
    'accid',
    'charid',
    'name',
    'rolelv',
    'createtime'
];

echo(json_encode($charBase->get($column)));
?>