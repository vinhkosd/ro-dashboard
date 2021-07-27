<?php
include __DIR__.'/../app/index.php';
use Illuminate\Database\Capsule\Manager as DB;
use Models\PaymentLogs;
use Models\ChargeCustomLogs;
use Carbon\Carbon;
validateLogin(true, false);//check account login
header('Content-Type: application/json');
$fromDate = !empty($_POST['fromDate']) ? Carbon::createFromFormat('d/m/Y', $_POST['fromDate'])->startOfDay() : false;
$toDate = !empty($_POST['toDate']) ? Carbon::createFromFormat('d/m/Y', $_POST['toDate'])->endOfDay() : Carbon::now()->endOfDay();
$paymentLogs = PaymentLogs::query();
$pendingChargeLogs = ChargeCustomLogs::query();
$pendingChargeLogs->leftJoin('charge_config', 'charge_config.id', '=', 'chargecustom_logs.type_charge');
$pendingChargeLogs->where('status', '>', 1);
if($fromDate && $toDate) {
    $paymentLogs->whereBetween('time', [$fromDate, $toDate]);
    $pendingChargeLogs->whereBetween('createdate', [$fromDate, $toDate]);
}

$column = [
    DB::raw('round(sum(money_thuc_nhan), 2) as money')
];

$columnPending = [
    DB::raw('sum(chargecustom_logs.money) as money'),
    DB::raw('charge_config.charge_title')
];

$dataReturn['paypal'] = $paymentLogs->get($column);

$dataReturn['other'] =$pendingChargeLogs->groupBy('chargecustom_logs.type_charge')
            ->get($columnPending);
echo(json_encode($dataReturn));
?>