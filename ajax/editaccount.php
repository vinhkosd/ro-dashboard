<?php
include __DIR__.'/../app/index.php';
use Models\Account;
use Illuminate\Support\Collection;
validateLogin(true, false);//check account login

if(isset($_POST)){
    $input = collect($_POST)->only(['id', 'account', 'email', 'password', 'active'])->map(function ($item, $key) {
        if(empty($item) && $key !== 'money')
            return null;
        return $item;
    })->toArray();

    $accountInfo = Account::where('id', $input['id'])->first();

    if(empty($input['password'])) {//không nhập pass thì không update ô password
        unset($input['password']);
    }

    if(!empty($input['email'])) {
        $input['old_email'] = $accountInfo['email'];
    }

    
    if(empty($accountInfo)){
        echo(json_encode(['error' => 'ID tài khoản không tồn tại. ID: '.$input['id']]));
    } else {
        Account::where('id', $input['id'])->update($input);
        echo(json_encode(['success' => 'Sửa tài khoản '.$input['account'].' thành công. ID: '.$input['id']]));
    }
}
?>