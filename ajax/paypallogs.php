<?php
include __DIR__.'/../app/index.php';
use Models\PaymentLogs;
use Carbon\Carbon;
validateLogin(true, false);//check account login
header('Content-Type: application/json');
$fromDate = isset($_POST['fromDate']) ? Carbon::createFromFormat('d/m/Y', $_POST['fromDate'])->startOfDay() : false;
$toDate = isset($_POST['fromDate']) ? Carbon::createFromFormat('d/m/Y', $_POST['toDate'])->endOfDay() : false;
$filterText = isset($_POST['filterText']) && !empty($_POST['filterText']) ? $_POST['filterText'] : false;
$paymentLogs = PaymentLogs::query();
if($fromDate && $toDate) {
    $paymentLogs->whereBetween('time', [$fromDate, $toDate]);
}

if($filterText) {
    $paymentLogs->where(function($query) use ($filterText) {
        $query->where('card_type', 'like', '%'. $filterText .'%');
        $query->orWhere('account', 'like', '%'. $filterText .'%');
        $query->orWhere('account_email', 'like', '%'. $filterText .'%');
        $query->orWhere('note', 'like', '%'. $filterText .'%');
    });
    
}

echo(json_encode($paymentLogs->get()));
?>