<?php
include __DIR__.'/../app/index.php';
use Illuminate\Database\Capsule\Manager as DB;
use Models\AccountLogin;
use Carbon\Carbon;
validateLogin(true, false);//check account login
header('Content-Type: application/json');
$fromDate = Carbon::now()->startOfMonth()->timestamp;
$toDate = Carbon::now()->endOfMonth()->timestamp;
$paymentLogs = AccountLogin::query();

if($fromDate && $toDate) {
    $paymentLogs->whereBetween('timestamp', [$fromDate, $toDate]);
}

$column = [
    DB::raw('count(accid) as agg'),
    DB::raw('day(FROM_UNIXTIME(timestamp)) as day')
];

$paymentLogs->groupByRaw('day(FROM_UNIXTIME(timestamp))');
$paymentLogs->distinct('accid');

echo(json_encode($paymentLogs->get($column)->keyBy('day')));
?>