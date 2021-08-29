<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class AccountLogin extends Model
{
    //
    protected $table='account_logininfo';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
?>