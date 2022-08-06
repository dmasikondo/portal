<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\PastelAccountName;
use App\StudentEnrolment;
use App\StudentRegistration;
use App\SysRegistrationPeriod;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class StudentRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:staff_user");
    }

    public function index()
    {
        return view('staff.student-registration.index');
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            "student_no" => "required|exists:users,student_no"
        ]);

        $student = User::whereStudentNo(request("student_no"))->first();

        return redirect()->route("staff.student-registration.show", ["user" => $student->id]);
    }

    public function show(User $user)
    {
        $user->load("personalInformation");
        $enrolment = StudentEnrolment::with(["qualification", "programme"])->whereUserid($user->id)->get();
        $registration_periods = SysRegistrationPeriod::whereRaw("start_date <= NOW() AND end_date >= NOW()")->pluck("title", "id");
        $transactions = Transaction::whereAccountNumber(PastelAccountName::find($user->national_id)->Account)
            ->select(\DB::raw("(sum(Credit)-sum(Debit)) as acc_balance"))
            ->first();


        return view('staff.student-registration.view', compact('user', "enrolment", "registration_periods", "transactions"));
    }

    public function store(User $user)
    {
        $this->validate(\request(), [
            "enrolment" => "required|exists:student_enrolment,id",
//            "level" => "required",
//            "term" => "required",
            "registration_period" => "required|exists:sys_registration_periods,id"
        ]);

        if (StudentRegistration::where(["student_enrolment_id" => \request('enrolment'),
                "registration_period_id" => \request('registration_period')])->count() > 0)
            return back()->withErrors("Student is already registered for this period.");

        $student_registration = StudentRegistration::create([
            "student_enrolment_id" => \request('enrolment'), "registration_period_id" => \request('registration_period'),
            "level" => 1/**\request('level') **/, "term" => 1/**\request('term') **/
        ]);

        return redirect()->route("staff.student-registration.confirm", ["user" => $user->id, "studentRegistration" => $student_registration->id]);
    }

    public function confirm(User $user, StudentRegistration $studentRegistration)
    {
        $studentRegistration->load(['student_enrolment.programme', 'student_enrolment.qualification', 'registration_period']);

        return view('staff.registration-period.registration-record.complete', compact('user', 'studentRegistration'));
    }
}
