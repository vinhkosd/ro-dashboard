<?php
include __DIR__.'/../app/index.php';
use Models\CharBase;
use Carbon\Carbon;
validateLogin(true, false);//check account login

$accountList = CharBase::query();

$limit = $_GET['length'] ?? null;
$offset = $_GET['start'] ?? null;
$searchText = $_GET['search']['value'] ?? null;
$zoneId = $_GET['zoneid'] ?? null;
$page = floor($offset/$limit);

$columns = $_GET['columns'] ?? [];
$orderBy = !empty($_GET['order']) && !empty($_GET['order'][0]) ? $columns[$_GET['order'][0]['column']] : false;
$typeOrder = !empty($_GET['order']) && !empty($_GET['order'][0]) && !empty($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] == 'asc' ? 'asc' : 'desc';
if(!empty($searchText)) {
    $whereClause = [];
    $accountList->where(function($queryWhere) use ($columns, $searchText) {
        foreach($columns as $key => $value) {
            // var_dump(filter_var($value['searchable'], FILTER_VALIDATE_BOOLEAN));
            if(isset($value['searchable']) && filter_var($value['searchable'], FILTER_VALIDATE_BOOLEAN) && !empty($value['data'])) {
                $queryWhere->orWhereRaw("cast(".$value['data']." as CHAR) like '%$searchText%'");
            }
        }
    });
}

if(!empty($zoneId) && $zoneId > 0) {
    $accountList->where("zoneid", $zoneId);
}

if(!empty($orderBy) && !empty($orderBy['data']) && $orderBy['orderable']) {
    $columnOrder = $orderBy['data'];
    $accountList->orderBy($orderBy['data'], $typeOrder);
}

$column = [
    'zoneid',
    'accid',
    'charid',
    'name',
    'rolelv',
    'createtime'
];

$dataReturn = getPartial($accountList, $limit, $page, $column);
$dataReturn['draw'] = $_GET['draw'] ?? null;
$dataReturn['recordsTotal'] = $dataReturn['totalRecord'];
$dataReturn['recordsFiltered'] = $dataReturn['totalRecord'];
echo(json_encode($dataReturn));
?>