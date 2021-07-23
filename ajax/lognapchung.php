<?php
include __DIR__.'/../app/index.php';
use Illuminate\Database\Capsule\Manager as DB;
use Models\PaymentLogs;
use Models\ChargeCustomLogs;
use Carbon\Carbon;
validateLogin(true, false);//check account login
header('Content-Type: application/json');
$fromDate = Carbon::now()->startOfMonth();
$toDate = Carbon::now()->endOfMonth();
$paymentLogs = PaymentLogs::query();

if($fromDate && $toDate) {
    $paymentLogs->whereBetween('time', [$fromDate, $toDate]);
}
$index = 0;
$dataReturn = [];
$paypalList = $paymentLogs->get();

foreach($paypalList as $key => $value) {
    $value['charge_title'] = 'Paypal';
    $value['accid'] = $value['account_id'];
    $value['id'] = ++$index;
    array_push($dataReturn, $value);
}
$pendingChargeList =  ChargeCustomLogs::where(function($query) {
                                        $query->where('status', 3);
                                        $query->orWhere('status', 2);
                                    })
                                    ->leftJoin('charge_config', 'charge_config.id', '=', 'chargecustom_logs.type_charge')
                                    ->get([
                                        'chargecustom_logs.*',
                                        'charge_config.charge_title',
                                    ]);
foreach($pendingChargeList as $key => $value) {
    $value['id'] = ++$index;
    $value['time'] = $value['createdate'];
    array_push($dataReturn, $value);
}
echo json_encode($dataReturn);
// echo json_encode($paymentLogs->get());
?>