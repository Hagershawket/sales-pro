<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable =[
        "vendor_id", "name", "is_active"
    ];
}
