<?php
include __DIR__.'/../app/index.php';
use Models\AuctionItem;
validateLogin(true, false);//check account login

if(isset($_POST)){
    $input = collect($_POST)->only(['itemid', 'base_price', 'trade_price', 'zeny_price', 'auction', 'istemp'])->toArray();
    $input['batchid'] = 1;
    $input['isread'] = 0;
    $auctionInfo = AuctionItem::where('itemid', $input['itemid'])->first();

    if(empty($auctionInfo)){
        AuctionItem::insert($input);
        echo(json_encode(['success' => 'Thêm Item thành công! ID: '.$input['itemid']]));
    } else {
        echo(json_encode(['error' => 'Item ID Đã tồn tại, không thể thêm mới! ID: '.$input['itemid']]));
    }
}
?>