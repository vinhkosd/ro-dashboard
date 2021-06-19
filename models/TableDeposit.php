<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class TableDeposit extends Model
{
    //
    protected $table='table_deposit';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
?>