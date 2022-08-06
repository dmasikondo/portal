<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorInformation extends Model
{
    protected $primaryKey = "user_id";
    protected $fillable = ["name", "cellphone",
        "email", "house_number", "street_name", "suburb", "city", "country"];
}
