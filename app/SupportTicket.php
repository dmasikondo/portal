<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = ["ticketable_type", "ticketable_id", "issue_type", "description", "resolved_at"];

    public static $issue_types = [
        ["id" => 1, "student_detail" => "Unable To Create An Account", "auth" => 0],
        ["id" => 2, "student_detail" => "Unable To Login", "auth" => 1],
        ["id" => 3, "student_detail" => "Unable To Recover My Password", "auth" => 0],
        ["id" => 4, "student_detail" => "Stage 1", "auth" => 1],
        ["id" => 5, "student_detail" => "Stage 2", "auth" => 1],
        ["id" => 6, "student_detail" => "Stage 3", "auth" => 1],
        ["id" => 7, "student_detail" => "Stage 4", "auth" => 1],
        ["id" => 8, "student_detail" => "Stage 5", "auth" => 1],
        ["id" => 9, "student_detail" => "Stage 6", "auth" => 1],
        ["id" => 10, "student_detail" => "Stage 7", "auth" => 1],
        ["id" => 11, "student_detail" => "Stage 8", "auth" => 1],
        ["id" => 12, "student_detail" => "Stage 7", "auth" => 1],
    ];

    public function ticketable()
    {
        return $this->morphTo();
    }
}
