<?php
include __DIR__.'/../app/index.php';
use Models\ChargeCustomLogs;
use Models\ChargeConfig;
use Models\AccountLogs;
use Models\Account;
use Carbon\Carbon;
validateLogin(true, false);//check account login

$listIds = $_POST['checkedIds'];
$accountList = [];
$wrongData = [];
$idsSuccess = [];
foreach($listIds as $id) {
    $chargeLogQuery = ChargeCustomLogs::query();
    $chargeLogInfo = $chargeLogQuery->where('id', $id)->first();
    if(empty($chargeLogInfo)) {
        array_push($wrongData, 'ID :'. $id .' -> Không tồn tại dữ liệu, vui lòng thử lại sau!');
    } else {
        if(intval($chargeLogInfo['status']) <> 0){
            
            array_push($wrongData, 'ID :'. $id .' -> ID đã được duyệt, vui lòng tải lại dữ liệu!');
        }
        else {
            $chargeConfigInfo = ChargeConfig::where('id', $chargeLogInfo['type_charge'])->first();
            if(empty($chargeConfigInfo)) {
                array_push($wrongData, 'ID :'. $id .' -> Không tìm thấy bank! vui lòng thử lại');
            } else {
                $accountLogsData = [
                    'account'     => $chargeLogInfo['account'],
                    'log_title'   => $chargeConfigInfo['charge_title'].' recharge failed',
                    'log_content' => "Cant recharge [" . $chargeLogInfo['money'] . "] USD! If this information is incorrect, please contact the administrator!" ,
                    'log_time'    => Carbon::now(),
                    'type'        => 'payment',
                ];
                array_push($accountList, $chargeLogInfo['account']);
                array_push($idsSuccess, $id);
                
                AccountLogs::insert($accountLogsData);
                ChargeCustomLogs::where('id', $id)->update(['status' => 1]);
            }
        }
    }
    
}

echo(json_encode([
    'success' => $idsSuccess,
    'account' => $accountList,
    'wrong_data' => $wrongData
    ]));
?>