<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\PastelAccountName;
use App\StaffUserEnrolmentPermissions;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentModificationController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:staff_user']);
    }

    public function editBasic(User $user)
    {
        $user->load(["personalInformation", "contactInformation", "studentEnrolledCourses.programme"]);

        $departments = DB::table("department");

        if (\Auth::guard("staff_user")->user()->user_type != "admin" || \Auth::guard("staff_user")->user()->user_type == "enrolment_user") {
            $mydeps = StaffUserEnrolmentPermissions::whereStaffUserId(\Auth::guard("staff_user")->id())->pluck('department_id');
//            $department_programmes = $department_programmes->whereIn("departmentid", $mydeps);

            $departments = $departments->whereIn("id", $mydeps);
        }

        $departments = $departments->pluck('name', 'id')->all();

//        $enrolled_programme = $department_programmes->whereId($base_enrolled_student->programmeid)->first();

//        if (is_null($enrolled_programme))
//            return redirect()->route('staff.students.enrolment')
//                ->withErrors("The record either doesn't exist or you are not authorized to view it.");

//        return $user;
        return view("staff.students.modifier.basic-information", compact('user', 'departments'));
    }


    public function updateBasic(Request $request, User $user)
    {
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
            Rule::unique("users", "national_id")->ignore($user->id)
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

        $this->validate($request, $rules, $messages);


        $array = $request->only(['title', 'first_name', 'maiden_name', 'gender', 'date_of_birth', 'national_id', "mode_of_entry", "phone_number",
            "house_number", "street_name", "suburb", "city", "district", "country"]);

        $array["last_name"] = \request("surname");

        $national_id = strtoupper(\request("national_id"));
        $user->update([
            'first_name' => strtoupper(\request("first_name")),
            'last_name' => strtoupper(\request("surname")),
            'maiden_name' => strtoupper(\request("maiden_name")),
            'national_id' => $national_id,
        ]);

        $pastel = PastelAccountName::find($user->national_id);

        if (!is_null($pastel)) {
            $pastel->update(["national_id" => $national_id]);
        } else {
            PastelAccountName::create(["national_id" => $national_id, "Account" => $national_id]);
        }


        $user->personalInformation()->updateOrCreate([
            'user_id' => $user->id], [
            "title" => strtoupper(\request("title")),
            "gender" => strtoupper(\request("gender")),
            "date_of_birth" => \request("date_of_birth")
        ]);

        $user->contactInformation()->updateOrCreate(["user_id" => $user->id], [
            "cellphone" => strtoupper(\request("phone_number")),
            "house_number" => strtoupper(\request("house_number")),
            "street_name" => strtoupper(\request("street_name")),
            "suburb" => strtoupper(\request("suburb")),
            "city" => strtoupper(\request("city")),
            "district" => strtoupper(\request("district")),
            "country" => strtoupper(\request("country"))
        ]);

        $user->studentEnrolledCourses()->updateOrCreate([
            "userid" => $user->id], [
            "programmeid" => \request("course"),
            "qualificationid" => \request("qualification"),
            "mode_of_entry" => strtoupper(\request("mode_of_entry"))
        ]);

        return redirect()->route("staff.students.view", ["user" => $user->id])
            ->withStatus("Student account, successfully updated!");
    }


}
