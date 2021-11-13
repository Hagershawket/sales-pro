<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable =[
        "vendor_id", "name", "rate", "is_active"
    ];

    public function product()
    {
    	return $this->hasMany('App/Product');
    	
    }
}
