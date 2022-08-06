<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NextOfKinInformation extends Model
{
    protected $primaryKey = "user_id";
    protected $fillable = ["name", "next_of_kin_relationship_id", "national_id", "cellphone", "email", "house_number",
        "street_name", "suburb", "city", "country", 'title', 'surname', 'gender', "date_of_birth"];

}
