<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    protected $table = "programme";

    protected $fillable = ["id", "name", "departmentid"];

    public function department()
    {
        return $this->belongsTo(Department::class, "departmentid");
    }

    public function getProgrammeByQualificationDepartment($department, $qualification)
    {
        return DB::
        select("SELECT programme.id, `name` FROM programme,intake 
        WHERE programme.id=intake.programmeid AND programme.departmentid = ? AND intake.qualificationid= ?;", [$department, $qualification]);
    }
}
