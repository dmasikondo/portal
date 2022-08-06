<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolRecord extends Model
{
    protected $fillable = ["name", "town", "school_type", "from_year", "to_year", "from_level", "to_level"];
}
