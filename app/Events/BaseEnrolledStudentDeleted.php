<?php

namespace App\Events;

use App\BaseEnrolledStudent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BaseEnrolledStudentDeleted
{
    use Dispatchable, SerializesModels;
    /**
     * @var BaseEnrolledStudent
     */
    public $baseEnrolledStudent;

    /**
     * Create a new event instance.
     *
     * @param BaseEnrolledStudent $baseEnrolledStudent
     */
    public function __construct(BaseEnrolledStudent $baseEnrolledStudent)
    {
        $this->baseEnrolledStudent = $baseEnrolledStudent;
    }

}
