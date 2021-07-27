<?php
include __DIR__.'/../app/index.php';
use Models\ChargeCustomLogs;
use Carbon\Carbon;
validateLogin(true, false);//check account login

$accountList = ChargeCustomLogs::query();

$accountList->leftJoin('charge_config', 'charge_config.id', '=', 'chargecustom_logs.type_charge');

$limit = $_GET['length'] ?? null;
$offset = $_GET['start'] ?? null;
$searchText = $_GET['search']['value'] ?? null;
$page = floor($offset/$limit) + 1;

$fromDate = !empty($_GET['fromDate']) ? Carbon::createFromFormat('d/m/Y', $_GET['fromDate'])->startOfDay() : false;
$toDate = !empty($_GET['toDate']) ? Carbon::createFromFormat('d/m/Y', $_GET['toDate'])->endOfDay() : Carbon::now()->endOfDay();
$cardStatus = !empty($_GET['status']) && is_numeric($_GET['status']) ? intval($_GET['status']) : 0;

$columns = $_GET['columns'] ?? [];
$orderBy = !empty($_GET['order']) && !empty($_GET['order'][0]) ? $columns[$_GET['order'][0]['column']] : false;
$typeOrder = !empty($_GET['order']) && !empty($_GET['order'][0]) && !empty($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] == 'asc' ? 'asc' : 'desc';
if(!empty($searchText)) {
    $whereClause = [];
    foreach($columns as $key => $value) {
        if(isset($value['searchable']) && filter_var($value['searchable'], FILTER_VALIDATE_BOOLEAN) && !empty($value['data'])) {
            $accountList->orWhereRaw("cast(".$value['data']." as CHAR) like '%$searchText%'");
        }
    }
}

if($fromDate && $toDate) {
    $accountList->whereBetween('createdate', [$fromDate, $toDate]);
}

if($cardStatus >= 0) {
    $accountList->where('status', $cardStatus);
}

if(!empty($orderBy) && !empty($orderBy['data']) && $orderBy['orderable']) {
    $columnOrder = $orderBy['data'];
    $accountList->orderBy($orderBy['data'], $typeOrder);
}


$columns = [
    'chargecustom_logs.*',
    'charge_config.charge_title',
    'charge_config.img',
];


// if($fromDate && $toDate) {
//      $dataReturn = [
//         'data'          => [],
//         'page'          => 0,
//         'totalPage'     => 0,
//         'totalRecord'   => 0,
//         'totalFiltered' => 0
//     ];
// }
// else{
    $dataReturn = getPartial($accountList, $limit, $page, $columns);
// }
foreach($dataReturn['data'] as $key => $value) {
    $value['function'] = "";
    $value['region_money'] .= ' '.$value["currency"];
    if($value['status'] == 0) {//chưa duyệt
        $value['function'] = "<button type=\"button\" class=\"btn-duyet btn btn-success\">Duyệt</button>
        					<button type=\"button\" class=\"btn-sua-gia btn btn-warning\">Sửa giá</button>
        					<button type=\"button\" class=\"btn-tu-choi btn btn-danger\">Từ chối</button>";
    } else {
        switch($value['status']) {
            case 0:
                // $value['function'] = "Không hợp lệ";
                break;
            case 1:
                $value['function'] = '<span class="badge badge-danger">Không hợp lệ</span>';
                break;
            case 2:
                $value['function'] = '<span class="badge badge-warning">Đã sửa giá</span>';
                break;
            case 3:
                $totalAmount += $value['money'];
                $value['function'] = '<span class="badge badge-success">Thành công</span>';
                break;
        }
    }
    
}


if($_GET['draw'] == 1) {
    $totalAmount = ChargeCustomLogs::where(function($query) {
                                        $query->where('status', 3);
                                        $query->orWhere('status', 2);
                                    })->sum('money');
    $countCharge = ChargeCustomLogs::where('status', 3)->orWhere('status', 2)->distinct('accid')->count();
} else {
    if($fromDate && $toDate) {
        $totalAmount = ChargeCustomLogs::where(function($query) {
                                        $query->where('status', 3);
                                        $query->orWhere('status', 2);
                                    })->whereBetween('createdate', [$fromDate, $toDate])->sum('money');
        $countCharge = ChargeCustomLogs::where(function($query) { $query->where('status', 3); $query->orWhere('status', 2); })->whereBetween('createdate', [$fromDate, $toDate])->distinct('accid')->count();
    } else {
        $totalAmount = ChargeCustomLogs::where(function($query) {
                                        $query->where('status', 3);
                                        $query->orWhere('status', 2);
                                    })->sum('money');
        $countCharge = ChargeCustomLogs::where('status', 3)->orWhere('status', 2)->distinct('accid')->count();
    }
}

$dataReturn['draw'] = $_GET['draw'] ?? null;
$dataReturn['recordsTotal'] = $dataReturn['totalRecord'];
$dataReturn['recordsFiltered'] = $dataReturn['totalRecord'];
$dataReturn['totalAmount'] = $totalAmount;
$dataReturn['countChageFilter'] = $countCharge;
echo(json_encode($dataReturn));
?>