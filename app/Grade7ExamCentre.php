<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade7ExamCentre extends Model
{
    protected $fillable = ["user_id", "centre"];

    public function results()
    {
        return $this->hasMany(Grade7ExamResult::class);
    }
}
