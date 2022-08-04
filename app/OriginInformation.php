<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OriginInformation extends Model
{
    protected $primaryKey = "user_id";
    protected $fillable = ["nationality", "birth_country", "birth_town", "hometown", "race", "religion", "denomination"];
}
