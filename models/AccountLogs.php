<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class AccountLogs extends Model
{
    //
    protected $table='account_logs';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}