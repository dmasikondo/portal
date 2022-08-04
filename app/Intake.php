<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intake extends Model
{
    protected $table = "intake";

    protected $fillable = ["qualificationid", "programmeid"];

    public function programme()
    {
        return $this->belongsTo(Programme::class, "programmeid");
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class, "qualificationid");
    }

}
