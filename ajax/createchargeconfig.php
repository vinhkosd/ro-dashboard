<?php
include __DIR__.'/../app/index.php';
use Models\ChargeConfig;
use Illuminate\Support\Collection;
validateLogin(true, false);//check account login

if(isset($_POST)){
    $input = collect($_POST)->only(['charge_title', 'region'])->toArray();

    $chargeInfo = ChargeConfig::where('charge_title', $input['charge_title'])->first();

    
    if(!empty($chargeInfo)){
        echo(json_encode(['error' => 'Tên loại nạp đã tồn tại ']));
    } else {
        ChargeConfig::insert($input);
        echo(json_encode(['success' => 'Tạo thành công loại nạp mới !']));
    }
}
?>