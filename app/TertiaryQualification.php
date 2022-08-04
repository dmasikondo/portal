<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TertiaryQualification extends Model
{
    protected $fillable = ['user_id', "code", "institution_name", "qualification_title"];

    public function periods()
    {
        return $this->hasMany(TertiaryQualificationPeriod::class, 'tertiary_qualification_id');
    }
}
