<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class AuctionConfig extends Model
{
    protected $connection = 'game';
	
    protected $table='auction_config';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
?>