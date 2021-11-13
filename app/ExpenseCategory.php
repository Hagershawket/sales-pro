<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable =[
        "vendor_id", "code", "name", "is_active"  
    ];

    public function expense() {
    	return $this->hasMany('App\Expense');
    }
}
