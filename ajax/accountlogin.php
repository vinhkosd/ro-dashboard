<?php
include __DIR__.'/../app/index.php';
use Models\AccountLogin;
use Carbon\Carbon;
validateLogin(true, false);//check account login

$accountList = AccountLogin::query();

$accountList->leftJoin('account', 'account.id', '=', 'account_logininfo.accid');

$limit = $_GET['length'] ?? null;
$offset = $_GET['start'] ?? null;
$searchText = $_GET['search']['value'] ?? null;
$page = floor($offset/$limit) + 1;

$fromDate = !empty($_GET['fromDate']) ? Carbon::createFromFormat('d/m/Y', $_GET['fromDate'])->startOfDay()->timestamp : false;
$toDate = !empty($_GET['toDate']) ? Carbon::createFromFormat('d/m/Y', $_GET['toDate'])->endOfDay()->timestamp : false;

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
    $accountList->whereBetween('timestamp', [$fromDate, $toDate]);
}

if(!empty($orderBy) && !empty($orderBy['data']) && $orderBy['orderable']) {
    $columnOrder = $orderBy['data'];
    $accountList->orderBy($orderBy['data'], $typeOrder);
}

$accountList->distinct('accid');



$columns = [
    'account_logininfo.*',
    'account.account',
    'account.email',
    'account.money',
    'account.old_email'
];

$countToday = AccountLogin::whereBetween('timestamp', [Carbon::now()->startOfDay()->timestamp, Carbon::now()->endOfDay()->timestamp])->distinct('accid')->count();
$countYesterday = AccountLogin::whereBetween('timestamp', [Carbon::yesterday()->startOfDay()->timestamp, Carbon::yesterday()->endOfDay()->timestamp])->distinct('accid')->count();
$countWeek = AccountLogin::whereBetween('timestamp', [Carbon::now()->startOfWeek()->timestamp, Carbon::now()->endOfWeek()->timestamp])->distinct('accid')->count();
$countMonth = AccountLogin::whereBetween('timestamp', [Carbon::now()->startOfMonth()->timestamp, Carbon::now()->endOfMonth()->timestamp])->distinct('accid')->count();

$dataReturn = getPartial($accountList, $limit, $page, $columns);
$dataReturn['draw'] = $_GET['draw'] ?? null;
$dataReturn['recordsTotal'] = $dataReturn['totalRecord'];
$dataReturn['recordsFiltered'] = $dataReturn['totalRecord'];
$dataReturn['countToday'] = $countToday;
$dataReturn['countYesterday'] = $countYesterday;
$dataReturn['countWeek'] = $countWeek;
$dataReturn['countMonth'] = $countMonth;
echo(json_encode($dataReturn));
?>