<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class CharBase extends Model
{
    protected $connection = 'game';
	
    protected $table='charbase';
    
    protected $primaryKey='charid';
    
    public $timestamps = false;
    
    protected $guarded = ['charid'];
}
?>