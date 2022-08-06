<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfileUpdatePlan extends Model
{
    protected $fillable = ["stage", "total_stages", "route", "status", "exception_routes"];

    protected $casts = [
        'exception_routes' => 'array',
    ];

}
