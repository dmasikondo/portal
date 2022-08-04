<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseStudentRecord extends Model
{
    protected $fillable = ["DCLink", "Account", "Name", "Telephone", "DCBalance", "ucARSTUDENTNO"];


}
