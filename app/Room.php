<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ["hostel_id", "name", "gender_id", "room_size", "staff_user_id"];

    private $gender = [0 => "both", 1 => "Male", 2 => "Female"];

    public function beds()
    {
        return $this->hasMany(Bed::class, "room_id");
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class, "hostel_id");
    }

    public function getGenderAttribute()
    {
        return $this->gender[$this->gender_id];
    }
}
