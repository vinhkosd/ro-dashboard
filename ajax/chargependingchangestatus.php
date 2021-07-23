<?php
include __DIR__.'/../app/index.php';
use Models\ChargeCustomLogs;
use Models\ChargeConfig;
use Models\AccountLogs;
use Models\Account;
use Carbon\Carbon;
validateLogin(true, false);//check account login

$chargeLogQuery = ChargeCustomLogs::query();
$input = collect($_POST)->only(['id', 'accid', 'account', 'money', 'status', 'type_charge'])->toArray();
// var_dump($input);
$chargeLogInfo = $chargeLogQuery->where('id', $input['id'])->first();
if(empty($chargeLogInfo)) {
    echo(json_encode(['error' => 'Không tồn tại dữ liệu, vui lòng thử lại sau!']));
} else {
    if(intval($chargeLogInfo['status']) <> 0)
        echo(json_encode(['error' => 'Tài khoản đã được duyệt, vui lòng tải lại dữ liệu']));
    else {
        $chargeConfigInfo = ChargeConfig::where('id', $input['type_charge'])->first();
        if(empty($chargeConfigInfo)) {
            echo(json_encode(['error' => 'Không tìm thấy bank! vui lòng thử lại']));
        } else {
            if(intval($input['money']) > 0 && $input['status'] > 1) {//nạp thành công
                $accountLogsData = [
                    'account'     => $input['account'],
                    'log_title'   => $chargeConfigInfo['charge_title'].' recharge success',
                    'log_content' => "Recharge [" . $input['money'] . "] USD" ,
                    'log_time'    => Carbon::now(),
                    'type'        => 'payment',
                ];
                
                AccountLogs::insert($accountLogsData);
                Account::where('id', $input['accid'])->increment('money', intval($input['money']));
            } else {
                $accountLogsData = [
                    'account'     => $input['account'],
                    'log_title'   => $chargeConfigInfo['charge_title'].' recharge failed',
                    'log_content' => "Cant recharge [" . $input['money'] . "] USD! If this information is incorrect, please contact the administrator!" ,
                    'log_time'    => Carbon::now(),
                    'type'        => 'payment',
                ];
                
                AccountLogs::insert($accountLogsData);
            }
            
            ChargeCustomLogs::where('id', $input['id'])->update($input);
            echo(json_encode(['success' => 'Thành công']));
        }
        
    }
}
?>