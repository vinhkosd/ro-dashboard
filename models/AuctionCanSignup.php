<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class AuctionCanSignup extends Model
{
    protected $connection = 'game';
	
    protected $table='auction_can_signup';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
?>