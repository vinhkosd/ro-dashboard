<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class GiftCodeLogs extends Model
{
    //
    protected $table='giftcode_logs';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}