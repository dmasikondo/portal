<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    protected $fillable = ["student_enrolment_id", "registration_period_id", "level", "term"];

    public function student_enrolment()
    {
        return $this->belongsTo(StudentEnrolment::class, "student_enrolment_id");
    }

    public function registration_period()
    {
        return $this->belongsTo(SysRegistrationPeriod::class, "registration_period_id");
    }

}
