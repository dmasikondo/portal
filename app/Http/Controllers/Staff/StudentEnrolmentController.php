<?php

namespace App\Http\Controllers\Staff;

use App\BaseEnrolledStudent;
use App\Department;
use App\Http\Controllers\Controller;
use App\Programme;
use App\StaffUserEnrolmentPermissions;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentEnrolmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:staff_user']);
    }

    public function index()
    {
        return view('staff.students.enrolment.index');
    }

    public function viewEnrolments()
    {
        $field = request('field');
        $search = request('search');
        $courses = request("course");


        $enrolled_students = BaseEnrolledStudent::orderBy('created_at', 'desc');
        $departments = DB::table("department");

        if ($field == "national_id" && !is_null($search)) {
            $enrolled_students = $enrolled_students->where("national_id", "LIKE", "%" . $search . "%");
        }

        if ($field == "student_number" && !is_null($search)) {
            $enrolled_students = $enrolled_students->where("student_no", "LIKE", "%" . $search . "%");
        }

        if ($field == "full_name" && !is_null($search)) {
            $enrolled_students = $enrolled_students->whereRaw("CONCAT(`first_name`,' ',`last_name`) LIKE '%{$search}%'");
        }

        if (!is_null($courses)) {
            $enrolled_students = $enrolled_students->where("programmeid", $courses);
        }

        if (!is_null(\request("from_day")) && !is_null(\request("from_month")) && !is_null(\request("from_year")) &&
            !is_null(\request("to_day")) && !is_null(\request("to_month")) && !is_null(\request("to_year"))) {
            $from_date = \request("from_year") . "-" . \request("from_month") . "-" . \request("from_day");
            $to_date = \request("to_year") . "-" . \request("to_month") . "-" . \request("to_day");
            $enrolled_students = $enrolled_students->whereBetween("created_at", [$from_date, $to_date]);
        }

        if (\Auth::guard("staff_user")->user()->user_type != "admin" || \Auth::guard("staff_user")->user()->user_type == "enrolment_user") {
            $departments_id = StaffUserEnrolmentPermissions::whereStaffUserId(\Auth::guard("staff_user")->id())->pluck('department_id');
            $department_programmes = Programme::whereIn("departmentid", $departments_id)->pluck('id');
            $departments = $departments->whereIn("id", $departments_id);
            $enrolled_students = $enrolled_students->whereIn('programmeid', $department_programmes);
        }

        $departments = $departments->pluck('name', 'id')->all();

        $enrolled_students = $enrolled_students->paginate(15);

        return view('staff.students.enrolment.view-enrolled-student', compact('enrolled_students', 'departments'));
    }

    public function downloadEnrolments()
    {
        $enrolled_students = BaseEnrolledStudent::orderBy('created_at', 'desc');

        $field = request('field');
        $search = request('search');
        $courses = request("course");

        if ($field == "national_id" && !is_null($search)) {
            $enrolled_students = $enrolled_students->where("national_id", "LIKE", "%" . $search . "%");
        }

        if ($field == "student_number" && !is_null($search)) {
            $enrolled_students = $enrolled_students->where("student_no", "LIKE", "%" . $search . "%");
        }

        if ($field == "full_name" && !is_null($search)) {
            $enrolled_students = $enrolled_students->whereRaw("CONCAT(`first_name`,' ',`last_name`) LIKE '%{$search}%'");
        }

        if (!is_null($courses)) {
            $enrolled_students = $enrolled_students->where("programmeid", $courses);
        }

        if (!is_null(\request("from_day")) && !is_null(\request("from_month")) && !is_null(\request("from_year")) &&
            !is_null(\request("to_day")) && !is_null(\request("to_month")) && !is_null(\request("to_year"))) {
            $from_date = \request("from_year") . "-" . \request("from_month") . "-" . \request("from_day");
            $to_date = \request("to_year") . "-" . \request("to_month") . "-" . \request("to_day");
            $enrolled_students = $enrolled_students->whereBetween("created_at", [$from_date, $to_date]);
        }

        if (\Auth::guard("staff_user")->user()->user_type != "admin" || \Auth::guard("staff_user")->user()->user_type == "enrolment_user") {
            $departments_id = StaffUserEnrolmentPermissions::whereStaffUserId(\Auth::guard("staff_user")->id())->pluck('department_id');
            $department_programmes = Programme::whereIn("departmentid", $departments_id)->pluck('id');

            $enrolled_students = $enrolled_students->whereIn('programmeid', $department_programmes);
        }

        $enrolled_students = $enrolled_students->with(['programme.department', "qualification"])->get();
        $csvExporter = new \Laracsv\Export();

        return $csvExporter->build($enrolled_students, [
            "national_id" => "NAT ID NO:", "full_name" => "SURNAME", "student_no" => "STUD ID NO:",
            "programme.department.name" => "DEPARTMENT", "programme.name" => "COURSE",
            "qualification.name" => "LEVEL", "DURATION",
            "mode_of_entry_txt" => "MODE OF STUDY",
            "RESIDENT", "ENROLLED AS", "EXEMPTIONS", "NEXT OF KIN", "SPONSOR", "address" => "ADDRESS", "phone_number" => "CELL NO:"])
            ->download("enrolled_students_" . date('Y-m-d_His') . ".csv");;
    }

    public function create()
    {
        $departments = DB::table("department");

        if (\Auth::guard("staff_user")->user()->user_type != "admin" || \Auth::guard("staff_user")->user()->user_type == "enrolment_user") {
            $mydeps = StaffUserEnrolmentPermissions::whereStaffUserId(\Auth::guard("staff_user")->id())->pluck('department_id');
            $departments = $departments->whereIn("id", $mydeps);
        }

        $departments = $departments->pluck('name', 'id')->all();

        return view('staff.students.enrolment.create', compact('departments'));
    }

    public function edit(BaseEnrolledStudent $base_enrolled_student)
    {
        $department_programmes = Programme::orderBy('name');
        $departments = DB::table("department");

        if (\Auth::guard("staff_user")->user()->user_type != "admin" || \Auth::guard("staff_user")->user()->user_type == "enrolment_user") {
            $mydeps = StaffUserEnrolmentPermissions::whereStaffUserId(\Auth::guard("staff_user")->id())->pluck('department_id');
            $department_programmes = $department_programmes->whereIn("departmentid", $mydeps);

            $departments = $departments->whereIn("id", $mydeps);
        }

        $departments = $departments->pluck('name', 'id')->all();

        $enrolled_programme = $department_programmes->whereId($base_enrolled_student->programmeid)->first();

        if (is_null($enrolled_programme))
            return redirect()->route('staff.students.enrolment')
                ->withErrors("The record either doesn't exist or you are not authorized to view it.");

        return view('staff.students.enrolment.update', compact('base_enrolled_student', 'departments', 'enrolled_programme'));
    }

    public function update(Request $request, BaseEnrolledStudent $base_enrolled_student)
    {
        $new_enrolment_period = "2021-03-25 00:00:00";

        $request->merge([
            'date_of_birth' =>
                $request->get('birth_year') . '-' . $request->get('birth_month') . '-' . $request->get('birth_day')
        ]);

        $regex_name = "/^([a-zA-Z'-]{2,}(\s?))+$/";

        $regex_phone = "/^(\\+(\\d{1,3}))?[-. (]*(\\d{3})[-. )]*(\\d{3})[-. ]*(\\d{4})(?: *x(\\d+))?\\s*$/";

        $regex_national_id = "/^(([0-9]{2})([\-])([0-9]{6,})([A-Z]{1})([0-9]{2}))$/";

        $nationalIdRules = [
            "required",
//            Rule::unique("users", "national_id"),
            Rule::unique("base_enrolled_students", "national_id")
                ->where(function ($query) use ($new_enrolment_period) {
                    return $query->whereNull("deleted_at")
                        ->where('created_at', '>=', $new_enrolment_period);
                })->ignore($base_enrolled_student->id)
        ];

        if (\request('type_of_id') == 'zim_id')
            $nationalIdRules[] = 'regex:' . $regex_national_id;


        $rules = [
            'title' => 'required|in:Mr,Mrs,Miss,Dr,Ms,Rev,Sr,Prof',
            'first_name' => 'required|regex:' . $regex_name,
            'surname' => 'required|regex:' . $regex_name,
            'maiden_name' => 'nullable|regex:' . $regex_name,
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'national_id' => $nationalIdRules,
//            'phone_number' => "required|regex:" . $regex_phone,
            "qualification" => "required|exists:qualification,id",
            "course" => "required|exists:programme,id",
            "mode_of_entry" => "required|in:full_time,part_time,apprenticeship_res,apprenticeship_non_res,ojet",
            "phone_number" => 'required|regex:' . $regex_phone,
            "house_number" => "required",
            "street_name" => "required",
            "suburb" => "required",
            "city" => "required",
            "country" => "required|exists:countries,code",
        ];

        $messages = [
            "surname.regex" => "Surname mustn't have any initials.",
            "first_name.regex" => "First Name(s) must all be provided in full that is there mustn't be any initials.",
            "phone_number.regex" => "Phone Number must taken the form 0771234567 there must be no spaces"
        ];

        if ((\request('type_of_id') == 'zim_id')) {
            $messages["national_id.regex"] = "National ID must taken the form 99-999999X99 there must be no spaces.";
        }

        if ($request->ajax()) {
            $validate = \Validator::make($request->all(), $rules, $messages);

            if ($validate->fails()) {
                $error = $validate->messages();
                return ["error" => true, "messages" => $error];
            }

        } else {
            $this->validate($request, $rules, $messages);
        }

        $array = $request->only(['title', 'first_name', 'maiden_name', 'gender', 'date_of_birth', 'national_id', "mode_of_entry", "phone_number",
            "house_number", "street_name", "suburb", "city", "district", "country"]);
        $array["qualificationid"] = \request("qualification");
        $array["programmeid"] = \request("course");
        $array["last_name"] = \request("surname");
//        $array["added_by"] = \Auth::guard("staff_user")->id();


        $base_enrolled_student->update($array);

        if ($request->ajax()) {
            return ["error" => false, "record" => $base_enrolled_student,
                "offer_letter_link" => route('staff.students.enrolled.offer', ["id" => $base_enrolled_student->id])];
        } else {
            return redirect()->route('staff.students.enrolled.offer', ["id" => $base_enrolled_student->id])->withStatus("Student enrolment has been updated!");
        }
    }

    public function createBulk()
    {
        return view('staff.students.enrolment.enrol-student-bulk');
    }

    public function store(Request $request)
    {
        $new_enrolment_period = "2021-12-25 00:00:00";

        $request->merge([
            'date_of_birth' =>
                $request->get('birth_year') . '-' . $request->get('birth_month') . '-' . $request->get('birth_day')
        ]);

        $regex_name = "/^([a-zA-Z'-]{2,}(\s?))+$/";

        $regex_phone = "/^(\\+(\\d{1,3}))?[-. (]*(\\d{3})[-. )]*(\\d{3})[-. ]*(\\d{4})(?: *x(\\d+))?\\s*$/";

        $regex_national_id = "/^(([0-9]{2})([\-])([0-9]{6,})([A-Z]{1})([0-9]{2}))$/";

        $nationalIdRules = [
            "required",
//            Rule::unique("users", "national_id"),
            Rule::unique("base_enrolled_students", "national_id")->where(function ($query) use ($new_enrolment_period) {
                return $query->whereNull("deleted_at")
                    ->where('created_at', '>=', $new_enrolment_period);
            })

        ];

        if (\request('type_of_id') == 'zim_id')
            $nationalIdRules[] = 'regex:' . $regex_national_id;

        $rules = [
            'title' => 'required|in:Mr,Mrs,Miss,Dr,Ms,Rev,Sr,Prof',
            'first_name' => 'required|regex:' . $regex_name,
            'surname' => 'required|regex:' . $regex_name,
            'maiden_name' => 'nullable|regex:' . $regex_name,
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'national_id' => $nationalIdRules,
//            'phone_number' => "required|regex:" . $regex_phone,
            "qualification" => "required|exists:qualification,id",
            "course" => "required|exists:programme,id",
            "mode_of_entry" => "required|in:full_time,part_time,apprenticeship_res,apprenticeship_non_res,ojet",
            "phone_number" => 'required|regex:' . $regex_phone,
            "house_number" => "required",
            "street_name" => "required",
            "suburb" => "required",
            "city" => "required",
            "country" => "required|exists:countries,code",
        ];

        $unique_nat_id_error = "This student has already been enrolled during this enrolment period";
        $messages = [
            "surname.regex" => "Surname mustn't have any initials.",
            "first_name.regex" => "First Name(s) must all be provided in full that is there mustn't be any initials.",
            "phone_number.regex" => "Phone Number must taken the form 0771234567 there must be no spaces",
            "national_id.unique" => $unique_nat_id_error
        ];

        if ((\request('type_of_id') == 'zim_id')) {
            $messages["national_id.regex"] = "National ID must taken the form 99-999999X99 there must be no spaces.";
        }

        if ($request->ajax()) {
            $validate = \Validator::make($request->all(), $rules, $messages);

            if ($validate->fails()) {
                $error = $validate->messages();
                return ["error" => true, "messages" => $error];
            }

        } else {
            $this->validate($request, $rules, $messages);
        }

        $enrolled_before = BaseEnrolledStudent::where("national_id", \request("national_id"))
            ->where('created_at', '>=', $new_enrolment_period)->first();

        if (!is_null($enrolled_before)) {
            return back()->withErrors($unique_nat_id_error);
        }

        $department_id = Programme::select("departmentid")->find(\request("course"))->departmentid;
        $department = Department::find($department_id);

        $department_programmes = Programme::whereDepartmentid($department_id)->pluck('id');

        $enrolled_count = BaseEnrolledStudent::withTrashed()->whereIn('programmeid', $department_programmes)
            ->where('created_at', '>=', $new_enrolment_period)->count();

        $enrolled_count_padded = str_pad($enrolled_count, 3, "0", STR_PAD_LEFT);

        $id_existing = \DB::table("idwstudcard2016")->where("Account", $request->get("national_id"))->first();

        $existing = User::where("national_id", $request->get("national_id"))->first();

        if (is_null($existing) && is_null($id_existing)) {
            $enrolment_year = 22;
            $student_reg = ($enrolment_year) . $department->code . $department->number . $enrolled_count_padded . "HP";

            while (BaseEnrolledStudent::where("student_no", $student_reg)->count() > 0) {
                $enrolled_count++;
                $enrolled_count_padded = str_pad($enrolled_count, 3, "0", STR_PAD_LEFT);

                $student_reg = ($enrolment_year) . $department->code . $department->number . $enrolled_count_padded . "HP";
            }
        } else {
            if (!is_null($existing)) {
                $student_reg = $existing->student_no;
            } else {
                $student_reg = $id_existing->ucARSTUDENTNO;
            }
        }


        $array = $request->only(['title', 'first_name', 'maiden_name', 'gender', 'date_of_birth', 'national_id', "mode_of_entry", "phone_number",
            "house_number", "street_name", "suburb", "city", "district", "country"]);
        $array["qualificationid"] = \request("qualification");
        $array["programmeid"] = \request("course");
        $array["last_name"] = \request("surname");
        $array["student_no"] = $student_reg;
        $array["added_by"] = \Auth::guard("staff_user")->id();


        $enrollStudent = BaseEnrolledStudent::create($array);

        if ($request->ajax()) {
            return ["error" => false, "record" => $enrollStudent,
                "offer_letter_link" => route('staff.students.enrolled.offer', ["id" => $enrollStudent->id])];
        } else {
            return redirect()->route('staff.students.enrolled.offer', ["id" => $enrollStudent->id])->withStatus("Student has been enrolled!");
        }
    }

    public function confirmDelete(BaseEnrolledStudent $base_enrolled_student)
    {
        if (\Auth::guard("staff_user")->user()->user_type != "admin")
            return redirect()->route("staff.students.enrolment-view")->withErrors("You are not authorized to delete records.");

        $offer = $base_enrolled_student;
        return view('staff.students.enrolment.confirm-delete', compact('offer'));
    }

    public function destroy(BaseEnrolledStudent $base_enrolled_student)
    {
        if (\Auth::guard("staff_user")->user()->user_type != "admin")
            return redirect()->route("staff.students.enrolment-view")->withErrors("You are not authorized to delete records.");

        $base_enrolled_student->delete();
        return redirect()->route("staff.students.enrolment-view")->withStatus("You have successfully deleted the enrolment record.");

    }

    public function viewOfferLetter($id)
    {
        $offer = BaseEnrolledStudent::find($id);
        return view('staff.students.enrolment.offer-letter-done', compact('offer'));
    }

    public function viewGetEnrolment()
    {
        return view('staff.students.enrolment.reprint');
    }

    public function getEnrolment(Request $request, $loc)
    {
//        $regex_national_id = "/^(([0-9]{2})([\-])([0-9]{6,})([A-Z]{1})([0-9]{2}))$/";

        $rules = [
            'national_id' => 'required|exists:base_enrolled_students,national_id',
        ];
        $messages = [
            "national_id.exists" => "The National ID doesn't exist in the system.",
//            "national_id.regex" => "National ID must taken the form 99-999999X99 there must be no spaces."
        ];

        $this->validate($request, $rules, $messages);

        $enrolled = BaseEnrolledStudent::whereNationalId(\request('national_id'));

        if (\Auth::guard("staff_user")->user()->user_type != "admin" || \Auth::guard("staff_user")->user()->user_type == "enrolment_user") {
            $departments_id = StaffUserEnrolmentPermissions::whereStaffUserId(\Auth::guard("staff_user")->id())->pluck('department_id');
            $department_programmes = Programme::whereIn("departmentid", $departments_id)->pluck('id');

            $enrolled = $enrolled->whereIn("programmeid", $department_programmes);
        }

        $enrolled = $enrolled->first();

        if (is_null($enrolled))
            return back()
                ->withErrors("The record either doesn't exist or you are not authorized to view it.");

        if ($loc == "reprint")
            return redirect()->route('staff.students.enrolled.offer', ["id" => $enrolled->id]);

        return redirect()->route('staff.students.enrolment.edit', ["id" => $enrolled->id]);
    }

    public function viewStudentEdit()
    {
        return view('staff.students.enrolment.edit-enrolment');
    }
}
