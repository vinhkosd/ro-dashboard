<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class AuctionItem extends Model
{
    protected $connection = 'game';
	
    protected $table='auction_item';
    
    protected $primaryKey='itemid';
    
    public $timestamps = false;
    
    protected $guarded = ['itemid'];
}
?>