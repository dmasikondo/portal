<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffUserEnrolmentPermissions extends Model
{
    protected $fillable = ["staff_user_id", "department_id"];
}
