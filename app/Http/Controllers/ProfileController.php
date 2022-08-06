<?php

namespace App\Http\Controllers;

use App\ContactInformation;
use App\ContactVerification;
use App\EmailVerification;
use App\Grade7ExamCentre;
use App\Intake;
use App\SchoolRecord;
use App\SecondaryExamCertificate;
use App\StudentEnrolment;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends ProfileBaseController
{

    public function __construct()
    {
        $this->middleware("auth", ["except" => "processVerificationEmail"]);
        $this->middleware('profile.update.off');
    }

    public function confirmDeleteSchool($id)
    {
        $route = $this->activePlan()->route;
        $school_record = SchoolRecord::find(base64_decode($id));

        if (is_null($school_record) || $school_record->user_id != auth()->id() || !is_numeric(base64_decode($id)))
            return redirect()->route($route)->withErrors("The record either doesn't exist or you aren't allowed to access it.");

        return view('updaters.delete-school', compact('school_record'));

    }

    public function deleteSchool($id)
    {
        $route = $this->activePlan()->route;
        $school_record = SchoolRecord::find(base64_decode($id));

        if (is_null($school_record) || $school_record->user_id != auth()->id() || !is_numeric(base64_decode($id)))
            return redirect()->route($route)->withErrors("The record either doesn't exist or you aren't allowed to access it.");

        $school_record->delete();

        return redirect()->route($route)->withStatus("School record has been successfully deleted!");
    }

    public function stage4()
    {
        $school_records = SchoolRecord::whereUserId(auth()->id())->get();
        $g7_results = Grade7ExamCentre::with(['results'])
            ->whereUserId(auth()->id())->get();

        return view('profile.stage4', compact('school_records', 'g7_results'));
    }

    public function secondarySchool()
    {
        $school_records = SchoolRecord::whereUserId(auth()->id())->get();
        $certificates = SecondaryExamCertificate::with(['results'])
            ->whereUserId(auth()->id())->get();

        if ($school_records->where('school_type', 'S')->count() < 1)
            return redirect()->route("ur.addSecondary");

        foreach ($certificates as $certificate) {
            if ($certificate->results->count() < 1)
                return redirect()->route('ur.addCertificateResults', ["id" => base64_encode($certificate->id)]);
        }

        return view('profile.stage5', compact('school_records', 'certificates'));
    }

    public function processStage4()
    {
//        return redirect()->route('ur.stage5');
        return $this->planProgression();
    }

    public function processPrimarySchool()
    {
        $school_records = SchoolRecord::whereUserId(auth()->id())->whereSchoolType("P")->count();
        $certificates = Grade7ExamCentre::whereUserId(auth()->id())->count();

        if ($school_records < 1)
            return back()->withErrors("You need to provide at least 1 primary school you did your studies.");

        if ($certificates < 1)
            return back()->withErrors("You need to provide Grade 7 results.");

        return $this->planProgression();
    }

    public function processSecondarySchool()
    {
        $school_records = SchoolRecord::whereUserId(auth()->id())->whereSchoolType("S")->count();
        $certificates = SecondaryExamCertificate::with(["results"])->whereUserId(auth()->id())->get();

        if ($school_records < 1)
            return back()->withErrors("You need to provide at least 1 high school you did your studies.");

        if ($certificates->where("level", "O")->count() < 1)
            return back()->withErrors("You need to provide at least 1 O Level certificate.");

        foreach ($certificates as $certificate) {
            if ($certificate->results->count() < 1)
                return back()->withErrors("All certificates must have subjects before proceeding.");
        }

        return $this->planProgression();
    }

    public function addPrimary()
    {
        return view('updaters.add-primary');
    }

    public function storePrimary(Request $request)
    {
        $this->validate($request, [
            "school" => "required",
            "town" => "required",
            "from_grade" => "required|numeric|lte:to_grade",
            "to_grade" => "required|numeric|gte:from_grade",
            "from_year" => "required|numeric|date_format:Y|min:1900|max:" . date("Y"),
            "to_year" => "required|numeric|date_format:Y|min:1900|max:" . date("Y")
        ]);

        $from_year = intval($request->get("from_year"));
        $to_year = intval($request->get("to_year"));

        if ($from_year > $to_year) {
            return back()->withInput()->withErrors("The From Year field must always be less than or equal to the To Year field.");
        }


//        if (($request->get("to_grade") - $request->get("from_grade")) != ($request->get("to_year") - $request->get("from_year")))
//            return back()->withErrors("Mismatch between grade length and length in years.");

        $user = User::where(['id' => auth()->id()])->first();

        $record = [
            "user_id" => auth()->id(),
            "name" => $request->get("school"),
            "town" => $request->get("town"),
            "school_type" => "P",
            "from_year" => $request->get("from_year"),
            "to_year" => $request->get("to_year"),
            "from_level" => $request->get("from_grade"),
            "to_level" => $request->get("to_grade")
        ];

        $user->schoolRecords()->create($record);

        $back = redirect()->route('ur.stage4');

        if ($request->has("save_add")) {
            $back = back();
        }
        return $back->with('status', "Primary school record added!");
    }

    public function addGrade7Results()
    {
        return view('updaters.add-grade-7');
    }

    public function storeGrade7Results(Request $request)
    {

        $points_rule = "required|numeric|min:1|max:9";
        $this->validate($request, [
            "centre" => "required",
            "language" => "required|in:Shona,Ndebele",
            "language_points" => $points_rule,
            "mathematics_points" => $points_rule,
            "english_points" => $points_rule,
            "general_paper_points" => $points_rule,
        ]);

        $centre_details = $request->only("centre");
        $centre_details["user_id"] = \Auth::id();
        $centre = Grade7ExamCentre::create($centre_details);
//        return $request->only("subject-list");
        $arr = [
            ["subject" => "Mathematics", "points" => $request->get("mathematics_points")],
            ["subject" => "English", "points" => $request->get("english_points")],
            ["subject" => "General Paper", "points" => $request->get("general_paper_points")],
            ["subject" => $request->get("language"), "points" => $request->get("language_points")]
        ];

        $centre->results()->createMany($arr);

        return redirect()->route('ur.stage4')->with('status', "Grade 7 record added!");
    }

    public function confirmDeleteGrade7Results($id)
    {
        $g7_results = Grade7ExamCentre::find(base64_decode($id));

        if (is_null($g7_results) || $g7_results->user_id != auth()->id() || !is_numeric(base64_decode($id)))
            return redirect()->route("ur.stage4")->withErrors("The record either doesn't exist or you aren't allowed to access it.");

        return view('updaters.delete-grade7', compact('g7_results'));
    }

    public function deleteGrade7Results($id)
    {
        $g7_results = Grade7ExamCentre::find(base64_decode($id));

        if (is_null($g7_results) || $g7_results->user_id != auth()->id() || !is_numeric(base64_decode($id)))
            return redirect()->route("ur.stage4")->withErrors("The record either doesn't exist or you aren't allowed to access it.");

        $g7_results->delete();

        return redirect()->route("ur.stage4")->withStatus("Grade has been successfully deleted!");
    }

    public function addSecondary()
    {
        return view('updaters.add-secondary');
    }

    public function storeSecondary(Request $request)
    {
        $this->validate($request, [
            "school" => "required",
            "town" => "required",
            "from_form" => "required|numeric|lte:to_form",
            "to_form" => "required|numeric|gte:from_form",
            "from_year" => "required|numeric|date_format:Y|min:1900|max:" . date("Y"),
            "to_year" => "required|numeric|date_format:Y|min:1900|max:" . date("Y")
        ]);

        $from_year = intval($request->get("from_year"));
        $to_year = intval($request->get("to_year"));

        if ($from_year > $to_year) {
            return back()->withInput()->withErrors("The From Year field must always be less than or equal to the To Year field.");
        }

//        if (($request->get("to_form") - $request->get("from_form")) != ($request->get("to_year") - $request->get("from_year")))
//            return back()->withErrors("Mismatch between Form length and length in years.");

        $user = User::where(['id' => auth()->id()])->first();

        $record = [
            "user_id" => auth()->id(),
            "name" => $request->get("school"),
            "town" => $request->get("town"),
            "school_type" => "S",
            "from_year" => $request->get("from_year"),
            "to_year" => $request->get("to_year"),
            "from_level" => $request->get("from_form"),
            "to_level" => $request->get("to_form")
        ];

        $user->schoolRecords()->create($record);

        return redirect()->route('ur.secodarySchool')->with('status', "Secondary school record added!");
    }

    public function stage7()
    {
        return view('profile.stage7');
    }

    public function currentAcademicRecord()
    {
        return view('profile.stage8');
    }

    public function postCurrentAcademicRecord(Request $request)
    {
        $this->validate($request, [
            "qualification" => "required|exists:qualification,id",
            "course" => "required|exists:programme,id"
        ]);

        if (Intake::where(["programmeid" => $request->get("course"),
                "qualificationid" => $request->get("qualification")])->count() < 1) {
            return back()->withErrors("There was a course and qualification mismatch. Please enter again.");
        }

        StudentEnrolment::create([
            "userid" => \Auth::id(),
            "programmeid" => $request->get("course"),
            "qualificationid" => $request->get("qualification")
        ]);

        return $this->planProgression();
    }

    public function processStage7(Request $request)
    {
        $regex = "/^(\\+(\\d{1,3}))?[-. (]*(\\d{3})[-. )]*(\\d{3})[-. ]*(\\d{4})(?: *x(\\d+))?\\s*$/";

        $this->validate($request, [
            "name" => "required",
            "cellphone" => "required|regex:{$regex}",
            "email" => "required|email",
            "house_number" => "required",
            "street_name" => "required",
            "suburb" => "required",
            "city" => "required",
            "country" => "required|exists:countries,code",
        ]);

        $sponsor = $request->only(["name", "cellphone",
            "email", "house_number", "street_name", "suburb", "city", "country"]);

        $user = User::where(['id' => auth()->id()])->first();

        $user->sponsorInformation()->updateOrCreate(["user_id" => auth()->id()], $sponsor);

//        return redirect()->route('home')->with('status', "Your account details have been updated");
        return $this->planProgression();

    }

    public function verifyStudentContacts()
    {
        $user_id = \Auth::id();
        $contacts = ContactInformation::whereUserId($user_id)->first();
        $cellphone_verify = ContactVerification::whereUserId($user_id)->first();
        $email_verify = EmailVerification::whereUserId($user_id)->first();

        return view('profile.verification', compact('contacts', 'cellphone_verify', 'email_verify'));
    }

    public function processVerification()
    {
        $cellphone_verify = ContactVerification::whereUserId(\Auth::id())->whereNotNull("sms_verified_at")->first();
        $email_verify = EmailVerification::whereUserId(\Auth::id())->whereNotNull("email_verified_at")->first();

        if (is_null($cellphone_verify) || is_null($email_verify)) {
            return back()->withErrors("Please verify your e-mail and phone number to proceed.");
        }

        return $this->planProgression();

    }

    public function sendVerificationSMS($type)
    {
        $user_id = \Auth::id();
        $contacts = ContactInformation::whereUserId($user_id)->first();

        if (is_null($contacts)) {
            return back()->withErrors("Please fill in contact details to verify them.");
        }

        $verify_model = ContactVerification::whereUserId($user_id);

        $countWhetherVerified = ContactVerification::whereUserId($user_id)->whereNotNull('sms_verified_at')->count();
        if ($countWhetherVerified > 0) {
            return back()->withErrors("Your cellphone has already been verified.");
        }

        $verify_count = $verify_model->count();

        if ($verify_count > 0 && $type == "send") {
            return back()->withErrors("A verification code was already sent to your cellphone.");
        }

        if ($verify_count < 1 && $type == "resend")
            return back()->withErrors("A verification must be sent the first time before it can be resent.");

        if ($type == "go-back") {
            return $this->removeSMSVerification();
        }

        if ($type == "resend") {
            $timeSinceLastCode = Carbon::now()->diffInMinutes($verify_model->first()->updated_at);
            $waitTime = 5;
            if ($timeSinceLastCode < $waitTime) {
                $timeLeft = $waitTime - $timeSinceLastCode;
                return back()->withErrors("Please wait {$timeLeft} minute(s) before using resend option.");
            }
        }

        $this->saveSendCode($contacts->cellphone);

        return redirect()->route("ur.verifyStudent")->withStatus("A verification SMS has been sent to your cellphone.");
    }

    private function saveSendCode($cellphone)
    {
        $code = "SKIPPED";//$this->generateRandomNumbers();
        $contact_verification = ContactVerification::updateOrCreate(['user_id' => auth()->id()],
            ["sms_verified_at" => "2000-05-27 09:27:19", 'mobile_token' => $code]);
        $msg = "Your Harare Polytechnic Portal verification code is " . $code . ". Please include the hyphen(-) when entering the code.";

//        (new SMSService)->send($msg, $cellphone);

        return $contact_verification;
    }

    private function generateRandomNumbers()
    {
        return rand(100, 999) . "-" . rand(1000, 9999);
    }

    public function removeEmailVerification()
    {
        EmailVerification::destroy(auth()->id());

        return redirect()->route("ur.verifyStudent");
    }

    public function removeSMSVerification()
    {
        ContactVerification::destroy(auth()->id());

        return redirect()->route("ur.verifyStudent");
    }

    public function processVerificationSMS(Request $request)
    {
        $this->validate($request, [
            "verification_code" => "required"
        ]);

        $user_id = \Auth::id();
        $verify_model = ContactVerification::whereUserId($user_id)->first();

        if (is_null($verify_model)) {
            return back()->withErrors("Please request SMS verification before providing a verification code.");
        }

        if (!is_null($verify_model->sms_verified_at)) {
            return back()->withErrors("Phone number was already verify.");
        }

        if ($verify_model->mobile_token != $request->get("verification_code")) {
            return back()->withErrors("Incorrect verification code, please include the hyphen(-) when entering code.");
        }

        $verify_model->sms_verified_at = Carbon::now();
        $verify_model->save();

        return back()->withStatus("Your cellphone number has been successfully verified.");
    }

    public function sendVerificationEmail($type)
    {
        $user_id = \Auth::id();
        $contacts = ContactInformation::whereUserId($user_id)->first();

        if (is_null($contacts)) {
            return back()->withErrors("Please fill in contact details to verify them.");
        }

        $verify_model = EmailVerification::whereUserId($user_id);

        $countWhetherVerified = EmailVerification::whereUserId($user_id)->whereNotNull('email_verified_at')->count();
        if ($countWhetherVerified > 0) {
            return back()->withErrors("Your email has already been verified.");
        }

        $verify_count = $verify_model->count();

        if ($verify_count > 0 && $type == "send") {
            return back()->withErrors("A verification email was already sent to your email address.");
        }

        if ($type == "go-back") {
            if ($countWhetherVerified == 0)
                return $this->removeEmailVerification();
            return back()->withErrors("E-mail already verified!");
        }

        if ($verify_count < 1 && $type == "resend")
            return back()->withErrors("A verification email must be sent the first time before it can be resent.");

        if ($type == "resend") {
            $timeSinceLastCode = Carbon::now()->diffInMinutes($verify_model->first()->updated_at);
            $waitTime = 5;
            if ($timeSinceLastCode < $waitTime) {
                $timeLeft = $waitTime - $timeSinceLastCode;
                return back()->withErrors("Please wait {$timeLeft} minute(s) before using resend option.");
            }
        }

        $email_code = md5($contacts->email);
        $email_token = str_random(32);

        EmailVerification::updateOrCreate([
            'user_id' => $user_id,
            "email_code" => $email_code], [
            "email_token" => $email_token,
        ]);

        $data = [
            "first_name" => \Auth::user()->first_name,
            "last_name" => \Auth::user()->last_name,
            "email" => $contacts->email,
            "code" => $email_code,
            "token" => $email_token,
        ];

        \Mail::send('auth.email.confirm-email', $data, function ($message) use ($data) {
            $message->to($data["email"], $data["first_name"] . " " . $data["last_name"])->subject('Harare Polytechnic College E-mail Verification!');
        });

        return back()->with("status", "An e-mail with verification instructions has been sent to your {$data["email"]}");
    }

    public function processVerificationEmail($code, $token)
    {
        $email_ver = EmailVerification::whereEmailCode($code)->whereEmailToken($token)->first();

        if (is_null($email_ver)) {
            return redirect()->route('ur.verifyStudent')->withErrors("The e-mail verification link is invalid!");
        }

        if (!is_null($email_ver->email_verified_at)) {
            return redirect()->route('ur.verifyStudent')->withErrors("The e-mail has already been verified!");
        }

        $email_ver->email_verified_at = Carbon::now();
        $email_ver->save();
        return redirect()->route('ur.verifyStudent')->withStatus("Your email address has been verified");
    }
}
