<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentEnrolment extends Model
{
    protected $table = "student_enrolment";

    protected $fillable = ["userid", "programmeid", "qualificationid", "mode_of_entry"];

    public function programme()
    {
        return $this->belongsTo(Programme::class, "programmeid");
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class, "qualificationid");
    }
}
