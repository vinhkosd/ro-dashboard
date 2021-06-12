<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class AccBase extends Model
{
    protected $connection = 'game';
	
    protected $table='accbase';
    
    protected $primaryKey='accid';
    
    public $timestamps = false;
    
    protected $guarded = ['accid'];
}
?>