<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TertiaryQualificationPeriod extends Model
{
    protected $table = "tertiary_qualification_period";

    protected $fillable = ["tertiary_qualification_id", "period", "number_of_courses"];

    public $timestamps = false;

    public function results()
    {
        return $this->hasMany(TertiaryQualificationResults::class, "tertiary_qualification_period_id");
    }
}
