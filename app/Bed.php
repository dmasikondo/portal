<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $fillable = ["room_id", "bed_count"];

    public function student_residence_allocation()
    {
        return $this->hasOne(StudentResidenceAllocation::class, "bed_id");
    }

    public function room()
    {
        return $this->belongsTo(Room::class, "room_id");
    }
}
