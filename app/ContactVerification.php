<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactVerification extends Model
{
    protected $primaryKey = "user_id";

    public $incrementing = false;

    protected $fillable = ["user_id", "mobile_token", "sms_verified_at"];
}
