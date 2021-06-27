<?php
include __DIR__.'/../app/index.php';
use Models\GiftCode;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
validateLogin(true, false);//check account login

if(isset($_POST)){
    $input = collect($_POST)->only(['id', 'ItemID', 'Type', 'Title', 'count', 'prefix', 'codelen', 'BuyType'])->toArray();
    // echo json_encode($input);
    // $myfile = fopen("CODE".$input['prefix'].date('Ymdhis').".txt", "w") or die(json_encode(['error' => 'Không thể tạo file '."CODE".$input['prefix'].date('Ymdhis').".txt"]));
    $dataCode = "";
    for ($i = 1; $i <= intval($input['count']); $i++) {
        $codeRandom = empty($input['prefix']) ? Str::random(intval($input['codelen'])) : $input['prefix'].Str::random(intval($input['codelen']));
        $giftCodeArray = collect($input)->only(['id', 'ItemID', 'Type', 'Title', 'BuyType'])->toArray();
        $giftCodeArray['Code'] = $codeRandom;
        // var_dump($giftCodeArray);
        // fwrite($myfile, $codeRandom."\n");
        GiftCode::insert($giftCodeArray);
        $dataCode .= $codeRandom."\n";
    }
    
    // fclose($myfile);
    
    echo(json_encode([
        'success' => 'Tạo '.$input['count'].' code thành công',
        'dataCode' => $dataCode,
        'filename' => "CODE".$input['prefix'].date('Ymdhis').".txt"
    ]));
    // $packageInfo = TableDeposit::where('id', $input['id'])->first();

    // if(empty($packageInfo)){
    //     echo(json_encode(['error' => 'Gói không tồn tại. ID: '.$input['id']]));
    // } else {
    //     TableDeposit::where('id', $input['id'])->update($input);
    //     echo(json_encode(['success' => 'Sửa gói thành công. ID: '.$input['id']]));
    // }
}
?>