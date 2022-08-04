<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnregisteredUser extends Model
{
    protected $fillable = ["first_name", "surname", "national_id", "student_id", "email", "phone"];

    public function tickets()
    {
        return $this->morphMany(SupportTicket::class, "ticketable");
    }


}
