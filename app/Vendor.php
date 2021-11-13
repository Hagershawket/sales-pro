<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table='vendors';
    protected $fillable =[
        "admin_id", "short_name", "name", "phone", "location_long","location_lat", "address",
        "about", "about_short", "is_delivery", "delivery_charge_in", "delivery_charge_out", "image",
        "thumb", "cover_photo", "cover_photo_thumb", "start_time","end_time", "off_day", "social_list",
        "currency_code", "icon", "dial_code", "country_id", "is_whatsapp", "valid_from", "valid_to",
        "createdby_id", "is_active", "is_deleted",
    ];
    protected $casts = ['social_list' => 'array'];

    public function isActive()
    {
        return $this->is_active;
    }

    public function admin() {
        return $this->hasOne('App\User','v_id');
    }
}
