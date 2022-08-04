<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentResidenceAllocation extends Model
{
    protected $fillable = ["user_id", "bed_id", "residence_space_id", "allocation_date"];

    protected $dates = ["allocation_date"];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class, "bed_id");
    }

    public function residence_space()
    {
        return $this->belongsTo(ResidenceSpace::class, "residence_space_id");
    }
}
