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
            
$dataReturn = DB::select('select sum(agg) as agg,
			                     day
                from
                (SELECT
                	sum(money) as agg,
                	day(time) as day
                FROM
                	`payment_logs`
                WHERE
                	`time` BETWEEN ? AND ?
                GROUP BY
                	DAY (
                	time)
                UNION
                SELECT 
                    sum(money) as agg,
                    day(createdate) as day 
                FROM chargecustom_logs
                WHERE
                	`createdate` BETWEEN ? AND ?
                	and status > 1
                group by day(createdate)
                ) datachart
                group by day', [$fromDate, $toDate, $fromDate, $toDate]);
echo(json_encode(collect($dataReturn)->keyBy('day')));
?>