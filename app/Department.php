<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "department";

    protected $fillable = [];

    public function getQualificationsByDepartment($department_id)
    {
        return DB::select("SELECT DISTINCT qualification.* 
                          FROM programme,intake, qualification 
                          WHERE 
                          programme.id = intake.programmeid 
                          AND 
                          intake.qualificationid = qualification.id 
                          AND 
                          programme.departmentid = ?", [$department_id]);
    }
}
