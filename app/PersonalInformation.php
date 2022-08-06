<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{

    protected $primaryKey = "user_id";
    protected $fillable = ['user_id', "title", "gender", "passport", "marital_status", "height", "mass", "date_of_birth"];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullGenderAttribute()
    {
        if ($this->gender == "M") {
            return "Male";
        } elseif ($this->gender == "F") {
            return "Female";
        }
        return "Unspecified";
    }
}
