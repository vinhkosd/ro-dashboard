<?php
include __DIR__.'/../app/index.php';
use Models\TableDeposit;
use Illuminate\Support\Collection;
validateLogin(true, false);//check account login

if(isset($_POST)){
    $input = collect($_POST)->only(['id', 'ItemID', 'Type', 'Title', 'Price', 'BuyType'])->toArray();

    $packageInfo = TableDeposit::where('id', $input['id'])->first();

    if(empty($packageInfo)){
        echo(json_encode(['error' => 'Gói không tồn tại. ID: '.$input['id']]));
    } else {
        TableDeposit::where('id', $input['id'])->update($input);
        echo(json_encode(['success' => 'Sửa gói thành công. ID: '.$input['id']]));
    }
}
?>