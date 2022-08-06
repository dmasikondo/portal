<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PastelAccountName extends Model
{
    protected $primaryKey = 'national_id';


    public $timestamps = false;

    protected $fillable = ["national_id", "Account"];
}
