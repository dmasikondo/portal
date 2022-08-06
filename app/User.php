<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'maiden_name', 'student_id', 'email', 'password', 'national_id',
        'update_record', "student_no", "student_type"
    ];

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

    public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class, 'user_id');
    }

    public function originInformation()
    {
        return $this->hasOne(OriginInformation::class, 'user_id');
    }

    public function contactInformation()
    {
        return $this->hasOne(ContactInformation::class, "user_id");
    }

    public function nextOfKinInformation()
    {
        return $this->hasOne(NextOfKinInformation::class, "user_id");
    }

    public function sponsorInformation()
    {
        return $this->hasOne(SponsorInformation::class, 'user_id');
    }

    public function schoolRecords()
    {
        return $this->hasMany(SchoolRecord::class);
    }

    public function grade7ExamCentres()
    {
        return $this->hasMany(Grade7ExamCentre::class);
    }

    public function secondaryExamCertificates()
    {
        return $this->hasMany(SecondaryExamCertificate::class, "user_id");
    }

    public function tertiaryQualifications()
    {
        return $this->hasMany(TertiaryQualification::class);
    }

    public function userProfileUpdatePlan()
    {
        return $this->hasMany(UserProfileUpdatePlan::class, 'user_id');
    }

    public function contactVerification()
    {
        return $this->hasOne(ContactVerification::class, 'user_id');
    }

    public function emailVerification()
    {
        return $this->hasOne(EmailVerification::class, 'user_id');
    }

    public function studentEnrolledCourses()
    {
        return $this->hasMany(StudentEnrolment::class, 'userid');
    }

    public function studentResidenceAllocation()
    {
        return $this->hasOne(StudentResidenceAllocation::class, "user_id");
    }

    public function tickets()
    {
        return $this->morphMany(SupportTicket::class, "ticketable");
    }

}
