<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\PastelAccountName;
use App\Transaction;
use App\User;

class ExaminationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:staff_user");
    }

    public function index()
    {
        return view('staff.examinations.index');
    }

    public function search()
    {
        return view('staff.examinations.search');
    }

    public function processSearch()
    {
        $this->validate(request(), [
            "student_no" => "required|exists:users,student_no"
        ]);

        $to = request("to", "view-student");

        $user = User::whereStudentNo(request("student_no"))->first();

        $url = ($to == "view-student") ? 'staff.students.view' : 'staff.examinations.clear-student';

        return redirect()->route($url, ["user" => $user->id]);
    }

    public function clearStudent(User $user)
    {
        $user->load("personalInformation");

        $transactions = Transaction::whereAccountNumber(PastelAccountName::find($user->national_id)->Account)
            ->select(\DB::raw("(sum(Credit)-sum(Debit)) as acc_balance"))
            ->first();

        return view('staff.examinations.clear-student', compact('user', 'transactions'));
    }
}
