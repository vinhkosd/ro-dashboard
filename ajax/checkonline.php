<?php
include __DIR__.'/../app/index.php';
use Models\AccBase;
use Illuminate\Support\Facades\DB;
validateLogin(true, false);//check account login
$column = [
    'zoneid',
    'count'
];
$getOnline = AccBase::where('zoneid', '<>', 0)
->groupBy('zoneid')
->selectRaw('count(zoneid) as count,zoneid')
->get();
echo(json_encode($getOnline)) ;
?>