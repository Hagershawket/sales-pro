<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable =[
        "vendor_id", "code", "type", "amount", "minimum_amount", "user_id", "quantity", "used", "expired_date", "is_active"  
    ];
}
