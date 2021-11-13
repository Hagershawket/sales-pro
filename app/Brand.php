<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable =[

        "vendor_id", "title", "image", "is_active"
    ];

    public function product()
    {
    	return $this->hasMany('App/Product');
    	
    }
}
