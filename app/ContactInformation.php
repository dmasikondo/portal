<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    protected $primaryKey = "user_id";
    protected $fillable = ["cellphone", "email", "house_number", "street_name", "suburb", "city", "district", "country"];
}
