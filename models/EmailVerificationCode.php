<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerificationCode extends Model
{
    //
    protected $table='email_verification_code';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}