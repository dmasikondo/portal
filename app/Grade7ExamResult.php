<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade7ExamResult extends Model
{
    protected $fillable = ['grade7_exam_centre_id', "subject", "points"];
}
