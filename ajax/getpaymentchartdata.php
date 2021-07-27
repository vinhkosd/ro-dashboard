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
$pendingLogs = ChargeCustomLogs::query();

// if($fromDate && $toDate) {
//     $paymentLogs->whereBetween('time', [$fromDate, $toDate]);
// }

// $column = [
//     DB::raw('sum(money) as agg'),
//     DB::raw('day(time) as day')
// ];

// $columnPending = [
//     DB::raw('sum(money) as agg'),
//     DB::raw('day(createdate) as day')
// ];

// $paymentLogs->groupByRaw('day(time)');

// $dataReturn = ChargeCustomLogs::whereBetween('createdate', [$fromDate, $toDate])
//             ->union($paymentLogs)
//             ->get($columnPending);
$dataReturn = [];

if($fromDate && $toDate) {
    $paymentLogs->whereBetween('time', [$fromDate, $toDate]);
    $pendingLogs->whereBetween('createdate', [$fromDate, $toDate]);
}

$columnPaypal = [
    DB::raw('sum(money) as agg'),
    DB::raw('day(time) as day')
];

$columnPending = [
    DB::raw('sum(money) as agg'),
    DB::raw('day(createdate) as day')
];

$pendingLogs->where('status', '>', 1);

$paymentLogs->groupByRaw('day(time)');
$pendingLogs->groupByRaw('day(createdate)');

$dataPaypal = $paymentLogs->get($columnPaypal);
$dataPending = $pendingLogs->get($columnPending);
// die(json_encode($dataPaypal));
// die();

$dataPaypal->map(function($item) use (&$dataReturn) {
    // echo json_encode($item)."\r\n";
    if(!isset($dataReturn[$item['day']])) {
        $dataReturn[$item['day']] = [];
        $dataReturn[$item['day']]['agg'] = 0;
        $dataReturn[$item['day']]['day'] = $item['day'];
    }
    $dataReturn[$item['day']]['agg'] += floatval($item['agg']);
    // echo json_encode($dataReturn);
});
$dataPending->map(function($item) use (&$dataReturn) {
    if(!isset($dataReturn[$item['day']])) {
        $dataReturn[$item['day']] = [];
        $dataReturn[$item['day']]['agg'] = 0;
        $dataReturn[$item['day']]['day'] = $item['day'];
    }
    $dataReturn[$item['day']]['agg'] += floatval($item['agg']);
});
echo(json_encode($dataReturn));
?>