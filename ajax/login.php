<?php
include __DIR__.'/../app/index.php';
use Models\GMUsers;
validateLogin(true, true);

if(isset($_POST)){

    $email = $_POST['email'];
    $passWord = md5($_POST['password']);
    $whereClause = [
        'email' => $email,
        'password' => $passWord,
    ];
    $accountInfo = GMUsers::where($whereClause)->first();
    if(!empty($accountInfo)) {
        $_SESSION['accountId'] = $accountInfo['id'];
        $_SESSION['email'] = $email;
        $_SESSION['accountName'] = $accountInfo['name'];
        $_SESSION['passWord'] = $passWord;
        echo(json_encode(['success']));
    } else {
        echo(json_encode(['error' => 'Email or password not match']));
    }
}
?>