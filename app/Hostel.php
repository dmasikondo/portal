<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $fillable = ["residence_space_id", "name", "gender_id", "user_id"];

    public function rooms()
    {
        return $this->hasMany(Room::class, "hostel_id");
    }
}
