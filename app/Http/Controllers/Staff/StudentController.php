<?php

namespace App\Http\Controllers\Staff;

use App\Domain\EmailVerifier;
use App\Http\Controllers\Controller;
use App\PastelAccountName;
use App\Programme;
use App\StaffUserEnrolmentPermissions;
use App\StudentEnrolment;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use DB;
use Mail;

class StudentController extends Controller
{
    protected $recordsPerPage = 15;

    public function __construct()
    {
        $this->middleware(['auth:staff_user']);
    }

    public function index()
    {
        $users = $this->userModel();
        $departments = DB::table("department");

        if (\Auth::guard("staff_user")->user()->user_type != "admin" || \Auth::guard("staff_user")->user()->user_type == "enrolment_user") {
            $mydeps = StaffUserEnrolmentPermissions::whereStaffUserId(\Auth::guard("staff_user")->id())->pluck('department_id');
            $departments = $departments->whereIn("id", $mydeps);
        }

        $departments = $departments->pluck('name', 'id')->all();

        return view('staff.students.index', compact("users", "departments"));
    }

    private function userModel()
    {
        $field = request('field');
        $search = request('search');

        $students = User::select(["*"]);

//        if (is_null($search_term))
//            return $students->paginate($this->recordsPerPage);

        if ($field == "national_id" && !is_null($search)) {
            $students = $students->where("national_id", "LIKE", "%" . $search . "%");
        }

        if ($field == "student_number" && !is_null($search)) {
            $students = $students->where("student_no", "LIKE", "%" . $search . "%");
        }

        if ($field == "full_name" && !is_null($search)) {
            $students = $students->whereRaw("CONCAT(`first_name`,' ',`last_name`) LIKE '%{$search}%'");
        }

        $mydeps = DB::table("department")->pluck("id");

        if (\Auth::guard("staff_user")->user()->user_type != "admin" || \Auth::guard("staff_user")->user()->user_type == "enrolment_user") {
            $mydeps = StaffUserEnrolmentPermissions::whereStaffUserId(\Auth::guard("staff_user")->id())->pluck('department_id');
        }

        $mycourses = Programme::whereIn("departmentid", $mydeps)->pluck("id")->toArray();
        $courses = [];
        if (!is_null(request("department")) || !is_null(request("course"))) {
            if (!is_null(request("course"))) {
                $courses = [request("course")];
            } else {
                $courses = Programme::where("departmentid", request("department"))->pluck("id")->toArray();
            }
        }
//        dd($mycourses);
        $courses = (count($courses) > 0) ? array_intersect($mycourses, $courses) : $mycourses;

        $students = $students->whereHas('studentEnrolledCourses', function ($q) use ($courses) {
            $q->whereIn("programmeid", $courses);
        });

        return $students->paginate($this->recordsPerPage);
//            User::where(function ($query) use ($search_term) {
//            return $query->where("first_name", "LIKE", "%" . $search_term . "%")
//                ->orWhere("last_name", "LIKE", "%" . $search_term . "%")
//                ->orWhere("national_id", "LIKE", "%" . $search_term . "%")
//                ->orWhere("student_no", "LIKE", "%" . $search_term . "%");
//        });
    }

    public function view(User $user)
    {
        $user->load(['personalInformation', 'originInformation', 'contactInformation', 'sponsorInformation',
            'schoolRecords', 'grade7ExamCentres.results', 'secondaryExamCertificates.results', 'tertiaryQualifications.periods.results',
            'contactVerification', 'emailVerification'
        ]);
        $enrolment = StudentEnrolment::with(["qualification", "programme"])->whereUserid($user->id)->get();
        $pastel_acc = PastelAccountName::find($user->national_id);
        $transactions = Transaction::whereAccountNumber(((is_null($pastel_acc)) ? $user->national_id : $pastel_acc->Account))->get();
//        return $user;
        return view('staff.students.view', compact('user', "enrolment", "transactions"));
    }

    public function updateEmail(User $user)
    {
        $this->validate(request(), [
            "email" => "required|email"
        ]);

        $new_email = request("email");

        $vmail = new EmailVerifier();
        $vmail->setStreamTimeoutWait(20);
        $vmail->setEmailFrom('viska@viska.is');

        if (!$vmail->check($new_email)) {
            \Log::info(json_encode(["activity" => "invalid_email_attempted_change", "student_id" => $user->id, "new_email" => $new_email, "user_id" => auth()->id(), "time" => Carbon::now()]));
            return back()->withInput()->withErrors("E-mail account doesn't seem to exist on the Mail Exchange");
        }

        \Log::info(json_encode(["activity" => "email_change", "student_id" => $user->id, "old_email" => $user->email, "new_email" => $new_email, "user_id" => auth()->id(), "time" => Carbon::now()]));

        $user->update(["email" => $new_email]);
        $user->contactInformation()->updateOrCreate(["user_id" => $user->id], ["email" => $new_email]);
        $user->emailVerification()->delete();

        return back()->withStatus("The student's e-mail account has been updated!");
    }

    public function passwordReset(User $user)
    {
        $national_id = $user->national_id;

        $token = str_random(40);

        DB::table("password_resets")->updateOrInsert(
            ["national_id" => $national_id],
            ["token" => $token]);

        $data = ["route" => route("password.reset", ["token" => $token]), "user" => $user];

        Mail::send('auth.email.password-reset', $data, function ($message) use ($data) {
            $message->to($data["user"]->email, $data["user"]->name)->subject('Harare Polytechnic College Password Reset.');
        });

        return back()->with('success', "An email has been sent to the student with further instructions.");
    }

    public function updatePastelLink(User $user)
    {
        $this->validate(request(), [
            "pastel" => "required"
        ]);

        $national_id = $user->national_id;
        $pastel_acc = PastelAccountName::firstOrNew(["national_id" => $national_id]);
        $old_pastel = $pastel_acc->Account;
        $new_pastel = request("pastel");

        try {
            DB::beginTransaction();

            if (request("moveTransactions") == "yes") {
                Transaction::where("account_number", $old_pastel)
                    ->update(["account_number" => $new_pastel]);
            }

            $pastel_acc->Account = $new_pastel;
            $pastel_acc->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return back()->withErrors("There's was an internal error processing the update. Please try again later");
        }

        \Log::info(json_encode(
            ["activity" => "pastel_link_update", "student_id" => $user->id, "old_pastel" => $old_pastel, "new_pastel" => $new_pastel, "user_id" => auth()->id(), "time" => Carbon::now()]
        ));

        return back()->withStatus("The Pastel Account link has been updated please check transactions for updates");
    }
}
