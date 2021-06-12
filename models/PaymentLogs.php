<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLogs extends Model
{
    //
    protected $table='payment_logs';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
?>