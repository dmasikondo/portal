<?php

namespace App\Listeners;

use App\Events\BaseEnrolledStudentDeleted;

class AddDeletionLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BaseEnrolledStudentDeleted $event
     * @return void
     */
    public function handle(BaseEnrolledStudentDeleted $event)
    {
        \DB::table("base_enrolled_student_deletions")->insert([
            "staff_user_id" => auth("staff_user")->id(),
            "base_enrolled_student_id" => $event->baseEnrolledStudent->id]);
    }
}
