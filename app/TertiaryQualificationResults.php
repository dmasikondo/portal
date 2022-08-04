<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TertiaryQualificationResults extends Model
{
    protected $fillable = ['tertiary_qualification_period_id', "period", "module", "grade"];
}
