<?php

namespace App\Http\Controllers\Auth;

use App\BaseEnrolledStudent;
use App\BaseStudentRecord;
use App\Http\Controllers\Controller;
use App\PastelAccountName;
use App\StudentEnrolment;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.signup');
    }

    public function verify()
    {
        $this->validate(request(), [
            "surname" => "required",
            "national_id" => "required",
            "student_id" => "required"
        ]);

        $national_id = strtoupper(trim(request('national_id')));
        $student_id = strtoupper(trim(request('student_id')));

        $student_user = User::where(function ($q) use ($national_id, $student_id) {
            return $q->where('national_id', $national_id)->orWhere('student_no', $student_id);
        })->first();

        if (!is_null($student_user))
            return back()->withInput()->withErrors("This Student ID already has an account.");

        $year_str = substr(request("student_id"), 0, 2);
        $year_int = (is_numeric($year_str)) ? intval($year_str) : 0;
        if ($year_int >= 19) {
            $student = BaseEnrolledStudent::where([
                "student_no" => request("student_id"),
                "national_id" => $national_id])
                ->where("last_name", "LIKE", "%" . request('surname') . "%")->first();
            $student_type = "new";
        } else {
            //Validate records
            $student = BaseStudentRecord::where([
                "Account" => $national_id,
                "ucARSTUDENTNO" => strtoupper(request('student_id'))
            ])->where('Name', "LIKE", "%" . request('surname') . "%")->first();
            $student_type = "legacy";

            if (is_null($student)) {
                $student = \DB::table("idwstudcard2016")->where([
                    "Account" => $national_id,
                    "ucARSTUDENTNO" => strtoupper(request('student_id'))
                ])->where('Name', "LIKE", "%" . request('surname') . "%")->first();
                $student_type = "legacy_id";
            }

        }

        if (is_null($student))
            return back()->withInput()->withErrors("These credentials do not match our records.");

        \session(["student_type" => $student_type, "student_id" => $student->id]);

        return view("auth.set-password");
        //return request()->all();
    }

    public function register()
    {
        if (!\session()->has("student_id") || !\session()->has("student_type"))
            return redirect()->route("register")->withErrors("Your may have missed a step. Start here.");

        $regex_phone = "/^(\\+(\\d{1,3}))?[-. (]*(\\d{3})[-. )]*(\\d{3})[-. ]*(\\d{4})(?: *x(\\d+))?\\s*$/";

        $rules = [
            "password" => "required|string|min:6|confirmed",
            "email" => "required|email",
        ];

        if (in_array(\session("student_type"), ["legacy", "legacy_id"])) {
            $rules["cellphone"] = "required|regex:{$regex_phone}";
        }

        $this->validate(request(), $rules);

        if (\session("student_type") == "legacy") {
            $user = $this->createLegacyStudent();
        } elseif (\session("student_type") == "legacy_id") {
            $user = $this->createLegacyIdStudent();
        } else {
            $user = $this->createNewStudent();
        }

        if (is_string($user)) {
            return back()->withErrors($user);
        }

        session()->forget("student_id", "student_type");
        \Auth::login($user);

        return redirect()->route('ur.verifyStudent')->with("success", "Your account has been created, you may proceed to login.");
    }

    public function createLegacyStudent()
    {
        $contact = request()->only(["cellphone", "email"]);
        $contact["email"] = strtolower($contact["email"]);

        $student = BaseStudentRecord::find(\session("student_id"));

        if (is_null($student))
            return "This Student doesn't exist.";

        $name = explode(" ", ucwords(strtolower($student->Name)));
        $last_name = array_shift($name);
        $first_names = implode(" ", $name);
        $national_id = $student->Account;
        $password = \Hash::make(request('password'));

        $student_user = User::where('national_id', $national_id)->first();

        if (!is_null($student_user))
            return "This Student ID already has an account.";

        $user = User::create([
            "base_record_id" => $student->id,
            "student_no" => $student->ucARSTUDENTNO,
            "DCLink" => $student->DCLink,
            'first_name' => trim($first_names),
            'last_name' => trim($last_name),
            'national_id' => $national_id,
            'password' => $password,
            "email" => $contact["email"]
        ]);

        $user->contactInformation()->updateOrCreate(["user_id" => auth()->id()], $contact);

        $user->userProfileUpdatePlan()->createMany([
            ["stage" => 1, "total_stages" => 9, "route" => "ur.verifyStudent", "status" => "A", "exception_routes" => ['urp.verifyStudent', 'ur.verifyBySMS', 'urp.verifyBySMS', 'ur.verifyByEmail', 'urp.verifyByEmail', 'urp.updatePhone', "urp.updateEmail"]],
            ["stage" => 2, "total_stages" => 9, "route" => "ur.stage1", "exception_routes" => ['urp.stage1']],
            ["stage" => 3, "total_stages" => 9, "route" => "ur.stage2", "exception_routes" => ['urp.stage2']],
            ["stage" => 4, "total_stages" => 9, "route" => "ur.stage3", "exception_routes" => ['urp.stage3']],
            ["stage" => 5, "total_stages" => 9, "route" => "ur.stage4", "exception_routes" => ["urp.stage4Proceed", "ur.addPrimary", "urp.addPrimary", "ur.addGrade", "urp.addGrade", "ur.confirmDeleteSchool", "urp.deleteSchool", "ur.confirmDeleteG7", "urp.deleteG7"]],
            ["stage" => 6, "total_stages" => 9, "route" => "ur.secodarySchool", "exception_routes" => ["urp.secodarySchool", "ur.addSecondary", "urp.addSecondary", "urp.addOLevel", "urp.removeCert", "ur.addCertificate", "ur.addCertificateResults", "urp.addCertificateResults", "ur.confirmDeleteSchool", "urp.deleteSchool", "ur.confirmRemoveCert"]],
            ["stage" => 7, "total_stages" => 9, "route" => "ur.addTertiary", "exception_routes" => ['urp.stage4', 'urp.addTertiary', 'ur.addTertiaryPeriod', 'urp.addTertiaryPeriod', 'urp.tertiaryProceed', 'ur.addTertiaryPeriodResults', 'urp.addTertiaryPeriodResults', "ur.deleteTertiary", "urp.deleteTertiary"]],
            ["stage" => 8, "total_stages" => 9, "route" => "ur.stage5", "exception_routes" => ['urp.stage5']],
            ["stage" => 9, "total_stages" => 9, "route" => "ur.currentAcademic", "exception_routes" => ['urp.currentAcademic', "json.qualificationList", "json.programmeList"]],
        ]);

        $pastel = PastelAccountName::find($national_id);

        if (is_null($pastel)) {
            PastelAccountName::create(['national_id' => $national_id, "Account" => $national_id]);
        }

        return $user;
    }

    public function createLegacyIdStudent()
    {
        $contact = request()->only(["cellphone", "email"]);
        $contact["email"] = strtolower($contact["email"]);

        $student = \DB::table("idwstudcard2016")->find(\session("student_id"));

        if (is_null($student))
            return "This Student doesn't exist.";

        $name = explode(" ", ucwords(strtolower($student->Name)));
        $last_name = array_shift($name);
        $first_names = implode(" ", $name);
        $national_id = $student->Account;
        $password = \Hash::make(request('password'));

        $student_user = User::where('national_id', $national_id)->first();

        if (!is_null($student_user))
            return "This Student ID already has an account.";

        $user = User::create([
//            "base_record_id" => $student->id,
            "student_no" => $student->ucARSTUDENTNO,
//            "DCLink" => $student->DCLink,
            'first_name' => trim($first_names),
            'last_name' => trim($last_name),
            'national_id' => $national_id,
            'password' => $password,
            "email" => $contact["email"],
            "student_type" => \session("student_type")
        ]);

        $user->contactInformation()->updateOrCreate(["user_id" => auth()->id()], $contact);

        $user->userProfileUpdatePlan()->createMany([
            ["stage" => 1, "total_stages" => 9, "route" => "ur.verifyStudent", "status" => "A", "exception_routes" => ['urp.verifyStudent', 'ur.verifyBySMS', 'urp.verifyBySMS', 'ur.verifyByEmail', 'urp.verifyByEmail', 'urp.updatePhone', "urp.updateEmail"]],
            ["stage" => 2, "total_stages" => 9, "route" => "ur.stage1", "exception_routes" => ['urp.stage1']],
            ["stage" => 3, "total_stages" => 9, "route" => "ur.stage2", "exception_routes" => ['urp.stage2']],
            ["stage" => 4, "total_stages" => 9, "route" => "ur.stage3", "exception_routes" => ['urp.stage3']],
            ["stage" => 5, "total_stages" => 9, "route" => "ur.stage4", "exception_routes" => ["urp.stage4Proceed", "ur.addPrimary", "urp.addPrimary", "ur.addGrade", "urp.addGrade", "ur.confirmDeleteSchool", "urp.deleteSchool", "ur.confirmDeleteG7", "urp.deleteG7"]],
            ["stage" => 6, "total_stages" => 9, "route" => "ur.secodarySchool", "exception_routes" => ["urp.secodarySchool", "ur.addSecondary", "urp.addSecondary", "urp.addOLevel", "urp.removeCert", "ur.addCertificate", "ur.addCertificateResults", "urp.addCertificateResults", "ur.confirmDeleteSchool", "urp.deleteSchool", "ur.confirmRemoveCert"]],
            ["stage" => 7, "total_stages" => 9, "route" => "ur.addTertiary", "exception_routes" => ['urp.stage4', 'urp.addTertiary', 'ur.addTertiaryPeriod', 'urp.addTertiaryPeriod', 'urp.tertiaryProceed', 'ur.addTertiaryPeriodResults', 'urp.addTertiaryPeriodResults', "ur.deleteTertiary", "urp.deleteTertiary"]],
            ["stage" => 8, "total_stages" => 9, "route" => "ur.stage5", "exception_routes" => ['urp.stage5']],
            ["stage" => 9, "total_stages" => 9, "route" => "ur.currentAcademic", "exception_routes" => ['urp.currentAcademic', "json.qualificationList", "json.programmeList"]],
        ]);

        $pastel = PastelAccountName::find($national_id);

        if (is_null($pastel)) {
//            $pastel_record = BaseStudentRecord::where(function ($query) use ($student) {
//                return $query->where("ucARSTUDENTNO", $student->ucARSTUDENTNO)->orWhere("Account", $student->Account);
//            })->first();
//
//            if (!is_null($pastel_record)) {
//                PastelAccountName::create(['national_id' => $national_id, "Account" => $pastel_record->Account]);
//            } else {
            PastelAccountName::create(['national_id' => $national_id, "Account" => $national_id]);
//            }
        }

        return $user;
    }

    public function createNewStudent()
    {
        $student = BaseEnrolledStudent::find(\session("student_id"));

        $contact = request()->only(["email"]);
        $contact["email"] = strtolower($contact["email"]);

        if (is_null($student))
            return "This Student doesn't exist.";

        $student_no = $student->student_no;
        $title = $student->title;
        $first_name = $student->first_name;
        $last_name = $student->last_name;
        $maiden_name = $student->maiden_name;
        $gender = $student->gender;
        $date_of_birth = $student->date_of_birth;
        $national_id = $student->national_id;
        $qualificationid = $student->qualificationid;
        $programmeid = $student->programmeid;
        $mode_of_entry = $student->mode_of_entry;
        $phone_number = $student->phone_number;
        $house_number = $student->house_number;
        $street_name = $student->street_name;
        $suburb = $student->suburb;
        $city = $student->city;
        $district = $student->district;
        $country = $student->country;
        $password = \Hash::make(request('password'));

        $contact = array_merge($contact, ["cellphone" => $phone_number, "house_number" => $house_number, "street_name" => $street_name, "suburb" => $suburb, "city" => $city, "district" => $district, "country" => $country]);
        $user = User::create([
            "student_no" => $student_no,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'maiden_name' => $maiden_name,
            'national_id' => $national_id,
            'password' => $password,
            "email" => $contact["email"],
            "student_type" => "new"
        ]);

        $user->personalInformation()->create([
            'user_id' => $user->id,
            "title" => $title,
            "gender" => $gender,
            "date_of_birth" => $date_of_birth
        ]);

        $user->contactInformation()->updateOrCreate(["user_id" => $user->id], $contact);

        StudentEnrolment::create([
            "userid" => $user->id,
            "programmeid" => $programmeid,
            "qualificationid" => $qualificationid,
            "mode_of_entry" => $mode_of_entry
        ]);

        $user->userProfileUpdatePlan()->createMany([
            ["stage" => 1, "total_stages" => 7, "route" => "ur.verifyStudent", "status" => "A", "exception_routes" => ['urp.verifyStudent', 'ur.verifyBySMS', 'urp.verifyBySMS', 'ur.verifyByEmail', 'urp.verifyByEmail', 'urp.updatePhone', "urp.updateEmail"]],
            ["stage" => 2, "total_stages" => 7, "route" => "ur.stage1", "exception_routes" => ['urp.stage1']],
            ["stage" => 3, "total_stages" => 7, "route" => "ur.stage2", "exception_routes" => ['urp.stage2']],
            ["stage" => 4, "total_stages" => 7, "route" => "ur.stage4", "exception_routes" => ["urp.stage4Proceed", "ur.addPrimary", "urp.addPrimary", "ur.addGrade", "urp.addGrade", "ur.confirmDeleteSchool", "urp.deleteSchool", "ur.confirmDeleteG7", "urp.deleteG7"]],
            ["stage" => 5, "total_stages" => 7, "route" => "ur.secodarySchool", "exception_routes" => ["urp.secodarySchool", "ur.addSecondary", "urp.addSecondary", "urp.addOLevel", "urp.removeCert", "ur.addCertificate", "ur.addCertificateResults", "urp.addCertificateResults", "ur.confirmDeleteSchool", "urp.deleteSchool", "ur.confirmRemoveCert"]],
            ["stage" => 6, "total_stages" => 7, "route" => "ur.addTertiary", "exception_routes" => ['urp.stage4', 'urp.addTertiary', 'ur.addTertiaryPeriod', 'urp.addTertiaryPeriod', 'urp.tertiaryProceed', 'ur.addTertiaryPeriodResults', 'urp.addTertiaryPeriodResults', "ur.deleteTertiary", "urp.deleteTertiary"]],
            ["stage" => 7, "total_stages" => 7, "route" => "ur.stage5", "exception_routes" => ['urp.stage5']],
        ]);

        $pastel = PastelAccountName::find($national_id);

        if (is_null($pastel)) {
            PastelAccountName::create(['national_id' => $national_id, "Account" => $national_id]);
        }

        return $user;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
