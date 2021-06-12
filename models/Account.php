<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $table='account';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
?>