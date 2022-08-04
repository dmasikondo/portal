<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StaffUser extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['first_name', 'last_name', 'username', 'email', 'password', "user_type"];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function enrolmentPermissions()
    {
        return $this->hasMany(StaffUserEnrolmentPermissions::class, "staff_user_id");
    }

}
