<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable =[

        "vendor_id","name", 'image', "parent_id", "is_active"
    ];

    public function product()
    {
    	return $this->hasMany('App\Product');
    }
}
