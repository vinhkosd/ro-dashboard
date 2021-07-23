<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class ChargeConfig extends Model
{
    //
    protected $table='charge_config';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
?>