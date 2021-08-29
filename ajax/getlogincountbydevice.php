<?php
include __DIR__.'/../app/index.php';
use Illuminate\Database\Capsule\Manager as DB;
use Models\AccountLogin;
use Carbon\Carbon;
validateLogin(true, false);//check account login
header('Content-Type: application/json');
$fromDate = !empty($_POST['fromDate']) ? Carbon::createFromFormat('d/m/Y', $_POST['fromDate'])->startOfDay()->timestamp : false;
$toDate = !empty($_POST['toDate']) ? Carbon::createFromFormat('d/m/Y', $_POST['toDate'])->endOfDay() : Carbon::now()->endOfDay()->timestamp;
$accountLogin = AccountLogin::query();
if($fromDate && $toDate) {
    $accountLogin->whereBetween('timestamp', [$fromDate, $toDate]);
}

$column = [
    DB::raw('count(*) as count'),
    DB::raw('device')
];
$accountLogin->groupBy('device');

$dataReturn = $accountLogin->get($column);
echo(json_encode($dataReturn));
?>