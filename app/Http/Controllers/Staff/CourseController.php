<?php

namespace App\Http\Controllers\Staff;

use App\Department;
use App\Http\Controllers\Controller;
use App\Intake;
use App\Qualification;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:staff_user']);
    }

    public function index()
    {
        return view('staff.courses.index');
    }

    public function view()
    {
        $intake = Intake::with(['programme.department', 'qualification'])->paginate(15);
        return view('staff.courses.view-courses', compact('intake'));
    }

    public function create()
    {
        $departments = Department::pluck('name', 'id');
        $qualifications = Qualification::pluck('name', 'id');

        return view("staff.courses.create-course", compact('departments', 'qualifications'));
    }
}
