<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $fillable =[

        "vendor_id", "name", "percentage", "is_active"
    ];
}
