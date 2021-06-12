<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class GMUsers extends Model
{
    //
    protected $table='gm_users';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
?>