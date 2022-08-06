<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $primaryKey = "user_id";
    protected $fillable = ['user_id', "email_code", "email_token", 'email_verified_at'];
}
