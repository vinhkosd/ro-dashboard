<?php
include __DIR__.'/../app/index.php';
use Illuminate\Database\Capsule\Manager as DB;
use Models\Account;
use Carbon\Carbon;
validateLogin(true, false);//check account login
header('Content-Type: application/json');
$fromDate = Carbon::now()->startOfMonth();
$toDate = Carbon::now()->endOfMonth();
$paymentLogs = Account::query();

if($fromDate && $toDate) {
    $paymentLogs->whereBetween('regtime', [$fromDate, $toDate]);
}

$column = [
    DB::raw('count(id) as agg'),
    DB::raw('day(regtime) as day')
];

$paymentLogs->groupByRaw('day(regtime)');

echo(json_encode($paymentLogs->get($column)->keyBy('day')));
?>