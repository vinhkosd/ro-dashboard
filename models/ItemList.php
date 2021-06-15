<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class ItemList extends Model
{
    //
    protected $table='item_list';
    
    protected $primaryKey='itemid';
    
    public $timestamps = false;
    
    protected $guarded = ['itemid'];
}
?>