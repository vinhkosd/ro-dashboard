<?php
include __DIR__.'/../app/index.php';
use Models\GiftCode;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
validateLogin(true, false);//check account login

if(isset($_POST)){
    $input = collect($_POST)->only(['id', 'GiftID', 'ItemID', 'Title', 'count', 'prefix', 'codelen', 'BuyType'])->toArray();
    $dataCode = "";
    if(empty($input['GiftID'])) {
        $input['GiftID'] = GiftCode::max('GiftID') + 1;
    }
    
    for ($i = 1; $i <= intval($input['count']); $i++) {
        $codeRandom = empty($input['prefix']) ? strtoupper(Str::random(intval($input['codelen']))) : strtoupper($input['prefix'].Str::random(intval($input['codelen'])));
        $giftCodeArray = collect($input)->only(['id', 'GiftID', 'ItemID', 'Title', 'BuyType'])->toArray();
        $giftCodeArray['Code'] = $codeRandom;
        GiftCode::insert($giftCodeArray);
        $dataCode .= $codeRandom."\n";
    }
    
    
    echo(json_encode([
        'success' => 'Tạo '.$input['count'].' code thành công',
        'dataCode' => $dataCode,
        'filename' => "CODE".$input['prefix'].date('Ymdhis').".txt"
    ]));
}
?>