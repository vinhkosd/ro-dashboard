<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $connection = 'global';
	
    protected $table='zone';
    
    protected $primaryKey='zoneid';
    
    public $timestamps = false;
    
    protected $guarded = ['zoneid'];
}