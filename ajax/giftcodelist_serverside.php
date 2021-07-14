<?php
include __DIR__.'/../app/index.php';
use Models\GiftCode;
use Carbon\Carbon;
validateLogin(true, false);//check account login

$giftCodeQuery = GiftCode::query();

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
    $giftCodeQuery->where(function($queryWhere) use ($columns, $searchText) {
        foreach($columns as $key => $value) {
            // var_dump(filter_var($value['searchable'], FILTER_VALIDATE_BOOLEAN));
            if(isset($value['searchable']) && filter_var($value['searchable'], FILTER_VALIDATE_BOOLEAN) && !empty($value['data'])) {
                $queryWhere->orWhereRaw("cast(".$value['data']." as CHAR) like '%$searchText%'");
            }
        }
    });
}

if(!empty($zoneId) && $zoneId > 0) {
    $giftCodeQuery->where("zoneid", $zoneId);
}

if(!empty($orderBy) && !empty($orderBy['data']) && $orderBy['orderable']) {
    $columnOrder = $orderBy['data'];
    $giftCodeQuery->orderBy($orderBy['data'], $typeOrder);
}

if($giftID > 0) {
    $giftCodeQuery->where('GiftID', $giftID);
}

$column = [
    'zoneid',
    'accid',
    'charid',
    'name',
    'rolelv',
    'createtime'
];

$dataReturn = getPartial($giftCodeQuery, $limit, $page, $column);
$dataReturn['draw'] = $_GET['draw'] ?? null;
$dataReturn['recordsTotal'] = $dataReturn['totalRecord'];
$dataReturn['recordsFiltered'] = $dataReturn['totalRecord'];
echo(json_encode($dataReturn));
?>