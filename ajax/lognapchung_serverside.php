<?php
include __DIR__.'/../app/index.php';
use Models\PaymentLogs;
use Models\ChargeCustomLogs;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;
validateLogin(true, false);//check account login

$accountList = PaymentLogs::query();

$limit = $_GET['length'] ?? null;
$offset = $_GET['start'] ?? null;
$searchText = $_GET['search']['value'] ?? null;
$page = floor($offset/$limit) + 1;
$fromDate = !empty($_GET['fromDate']) ? Carbon::createFromFormat('d/m/Y', $_GET['fromDate'])->startOfDay() : false;
$toDate = !empty($_GET['toDate']) ? Carbon::createFromFormat('d/m/Y', $_GET['toDate'])->endOfDay() : Carbon::now()->endOfDay();

$columns = $_GET['columns'] ?? [];
$orderBy = !empty($_GET['order']) && !empty($_GET['order'][0]) ? $columns[$_GET['order'][0]['column']] : false;
$typeOrder = !empty($_GET['order']) && !empty($_GET['order'][0]) && !empty($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] == 'asc' ? 'asc' : 'desc';
if(!empty($searchText)) {
    $accountList->where(function($queryWhere) use ($columns, $searchText) {
        foreach($columns as $key => $value) {
            // var_dump(filter_var($value['searchable'], FILTER_VALIDATE_BOOLEAN));
            if(isset($value['searchable']) && filter_var($value['searchable'], FILTER_VALIDATE_BOOLEAN) && !empty($value['data'])) {
                $column = $value['data'];
                if($column == 'accid') $column = 'account_id';
                if($column == 'createdate') $column = 'time';
                if($column != 'charge_title') {
                    $queryWhere->orWhereRaw("cast(".$column." as CHAR) like '%$searchText%'");
                } else {//cast charge_title = Paypal
                    $queryWhere->orWhereRaw("'Paypal' like '%$searchText%'");
                }
            }
        }
    });
}

if($fromDate && $toDate) {
    $accountList->whereBetween('time', [$fromDate, $toDate]);
}

if(!empty($orderBy) && !empty($orderBy['data']) && $orderBy['orderable']) {
    $columnOrder = $orderBy['data'];
    $accountList->orderBy($orderBy['data'], $typeOrder);
}

$column = [
    'id',
    DB::raw("'Paypal' as charge_title"),
    DB::raw("'/img/paypal.png' as img"),
    DB::raw("account_id as accid"),
    DB::raw("time as createdate"),
    'money',
    'account'
];

$dataReturn = getPartial($accountList, $limit, $page, $column);
$dataReturn['draw'] = $_GET['draw'] ?? null;
$dataReturn['recordsTotal'] = $dataReturn['totalRecord'];
$dataReturn['recordsFiltered'] = $dataReturn['totalRecord'];
$dataReturn['countPaypal'] = count($dataReturn['data']);
// echo(json_encode($dataReturn));
$countPaypal = count($dataReturn['data']);
$offsetNapCham = $offset;
if($countPaypal == 0) {
    $offsetNapCham = abs($dataReturn['recordsTotal'] - $offset);
} else if($countPaypal < $limit) {
    //offset 20
    //count 1
    //total 21
    //offsetnapc 21 - 20 = 1;
    
    //offset 31
    //count 0
    //total 21
    //offsetnapc 21-31 = -10 => 10
     $offsetNapCham = 0;
}

$dataReturn['$offsetNapCham'] = $offsetNapCham;

//nạp chậm
$chargeCustomLogs = ChargeCustomLogs::query();

$chargeCustomLogs->leftJoin('charge_config', 'charge_config.id', '=', 'chargecustom_logs.type_charge');

$limit = $_GET['length'] ?? null;
$searchText = $_GET['search']['value'] ?? null;
$page = floor($offsetNapCham/$limit) + 1;

$columns = $_GET['columns'] ?? [];
$orderBy = !empty($_GET['order']) && !empty($_GET['order'][0]) ? $columns[$_GET['order'][0]['column']] : false;
$typeOrder = !empty($_GET['order']) && !empty($_GET['order'][0]) && !empty($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] == 'asc' ? 'asc' : 'desc';
if(!empty($searchText)) {
    $chargeCustomLogs->where(function($queryWhere) use ($columns, $searchText) {
        foreach($columns as $key => $value) {
            // var_dump(filter_var($value['searchable'], FILTER_VALIDATE_BOOLEAN));
            if(isset($value['searchable']) && filter_var($value['searchable'], FILTER_VALIDATE_BOOLEAN) && !empty($value['data'])) {
                $queryWhere->orWhereRaw("cast(".$value['data']." as CHAR) like '%$searchText%'");
            }
        }
    });
}

if($fromDate && $toDate) {
    $chargeCustomLogs->whereBetween('createdate', [$fromDate, $toDate]);
}

$chargeCustomLogs->where('status', '>', 1);

if(!empty($orderBy) && !empty($orderBy['data']) && $orderBy['orderable']) {
    $columnOrder = $orderBy['data'];
    $chargeCustomLogs->orderBy($orderBy['data'], $typeOrder);
}


$columns = [
    'chargecustom_logs.*',
    'charge_config.charge_title',
    'charge_config.img',
];

$dataNapCham = getPartial($chargeCustomLogs, $limit, $page, $columns, $offsetNapCham);

if($countPaypal < $limit) {
    //offset 20
    //count 1
    //total 21
    //offsetnapc 21 - 20 = 1;
    
    //offset 31
    //count 0
    //total 21
    //offsetnapc 21-31 = -10 => 10
    
    $countTakeNapCham = abs($limit - $countPaypal);
    $dataReturn['data'] = collect($dataReturn['data'])->concat(collect($dataNapCham['data'])->take($countTakeNapCham));
}
$dataReturn['data'] = collect($dataReturn['data'])->map(function($item){
    $d = DateTime::createFromFormat('Y-m-d H:i:s', $item['createdate']);
    if ($d !== false) {
       $item['createdate'] = $d->getTimestamp();
    }
    return $item;
});

$dataReturn['recordsTotal'] += $dataNapCham['totalRecord'];
$dataReturn['recordsFiltered'] += $dataNapCham['totalRecord'];
echo(json_encode($dataReturn));
?>