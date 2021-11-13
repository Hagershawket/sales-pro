<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class SuperAdmin extends Authenticatable
{

    use Notifiable;
    protected $table="superadmins";
    protected $guard    = 'admin';
    protected $fillable = [
         'role_id', 'name', 'email', 'password',"phone", "is_active", "is_deleted"
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isActive()
    {
        return $this->is_active;
    }

}
