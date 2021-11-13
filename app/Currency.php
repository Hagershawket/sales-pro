<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ["vendor_id", "name", "code", "exchange_rate"];
}
