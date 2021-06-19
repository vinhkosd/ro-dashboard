<?php
include __DIR__.'/../app/index.php';
use Illuminate\Database\Capsule\Manager as DB;
use Models\PaymentLogs;
use Carbon\Carbon;
validateLogin(true, false);//check account login
header('Content-Type: application/json');
$fromDate = Carbon::now()->startOfMonth();
$toDate = Carbon::now()->endOfMonth();
$paymentLogs = PaymentLogs::query();

if($fromDate && $toDate) {
    $paymentLogs->whereBetween('time', [$fromDate, $toDate]);
}

$column = [
    DB::raw('sum(money) as agg'),
    DB::raw('day(time) as day')
];

$paymentLogs->groupByRaw('day(time)');

echo(json_encode($paymentLogs->get($column)->keyBy('day')));
?>