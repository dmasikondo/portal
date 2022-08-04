<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysRegistrationPeriod extends Model
{
    protected $fillable = ["title", "start_date", "end_date"];

    protected $dates = ["start_date", "end_date"];


}
