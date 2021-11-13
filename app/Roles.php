<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable =[
       "vendor_id", "name", "description", "guard_name", "is_active"
    ];
}
