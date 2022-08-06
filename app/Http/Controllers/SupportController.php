<?php

namespace App\Http\Controllers;

use App\BaseEnrolledStudent;
use App\BaseStudentRecord;
use App\PastelAccountName;
use App\SupportTicket;
use App\UnregisteredUser;
use App\User;
use App\UserProfileUpdatePlan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mail;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth", ["only" => ["storeRegistered"]]);
        $this->middleware('auth:staff_user', ["except" => ["create", "storeUnregistered", "storeRegistered"]]);
    }

    public function studentFinderForm()
    {
        $this->validate(request(), [
            "surname" => "required_with_all:national_id,student_id",
            "national_id" => "required_with_all:surname,student_id",
            "student_id" => "required_with_all:surname,national_id"
        ]);

        $national_id = strtoupper(trim(request('national_id')));
        $student_id = strtoupper(trim(request('student_id')));

        $student_user = User::where(function ($q) use ($national_id, $student_id) {
            return $q->where('national_id', $national_id)->orWhere('student_no', $student_id);
        })->first();
//        return $student_user;
        $st_type = (is_null($student_user)) ? null : "user";
        $student = null;

        if (is_null($student_user) && !empty($national_id) && !empty($student_id)) {
            $year_str = substr(request("student_id"), 0, 2);
            $year_int = (is_numeric($year_str)) ? intval($year_str) : 0;
            if ($year_int >= 19) {
                $student = BaseEnrolledStudent::where([
                    "student_no" => request("student_id"),
                    "national_id" => $national_id])
                    ->where("last_name", "LIKE", "%" . request('surname') . "%")->first();
                $st_type = "new";

                if (is_null($student)) {
                    $student = BaseEnrolledStudent::where(function ($q) use ($national_id) {
                        $q->where("student_no", request("student_id"))
                            ->orWhere("national_id", $national_id)
                            ->orWhere("last_name", "LIKE", "%" . request('surname') . "%");
                    })->get();
                    $st_type = "new_search";
                }
            } else {
                //Validate records
                $student = BaseStudentRecord::where([
                    "Account" => $national_id,
                    "ucARSTUDENTNO" => strtoupper(request('student_id'))
                ])->where('Name', "LIKE", "%" . request('surname') . "%")->first();
                $st_type = "pastel";

                if (is_null($student)) {
                    $student = \DB::table("idwstudcard2016")->where([
                        "Account" => $national_id,
                        "ucARSTUDENTNO" => strtoupper(request('student_id'))
                    ])->where('Name', "LIKE", "%" . request('surname') . "%")->first();
                    $st_type = "idcard";
                }

                if (is_null($student)) {
                    $student = \DB::table("idwstudcard2016")->where(function ($q) use ($national_id) {
                        $q->where("ucARSTUDENTNO", request("student_id"))
                            ->orWhere("Account", $national_id)//                            ->orWhere("Name", "LIKE", "%" . request('surname') . "%");
                        ;
                    })->get();
                    $st_type = "idcard_search";
                }
            }
        }
        return view("staff.students.finder.show", compact("student_user", "student", "st_type"));
    }

    public function idCardEditForm($card_id)
    {
        $student = \DB::table("idwstudcard2016")->find($card_id);
        if (is_null($student))
            return redirect()->route("staff.student-finder");
        $pastel_acc = PastelAccountName::find($student->Account);
        $pastel_account = (is_null($pastel_acc)) ? $student->Account : $pastel_acc->Account;
        return view("staff.students.finder.edit-id", compact('student', 'pastel_account'));
    }

    public function idCardEdit($card_id)
    {
        $regex_name = "/^([a-zA-Z'-]{2,}(\s?))+$/";

        $regex_national_id = "/^(([0-9]{2})([\-])([0-9]{6,})([A-Z]{1})([0-9]{2}))$/";

        $nationalIdRules = [
            "required",
            Rule::unique("users", "national_id"),
            Rule::unique("idwstudcard2016", "Account")->whereNot("id", $card_id)
        ];

        if (\request('type_of_id') == 'zim_id')
            $nationalIdRules[] = 'regex:' . $regex_national_id;

        $rules = [
            'full_name' => 'required|regex:' . $regex_name,
            "student_no" => 'required',
            'national_id' => $nationalIdRules,
        ];

        $messages = [
            "full_name.regex" => "Name(s) must all be provided in full that is there mustn't be any initials.",
        ];

        if ((\request('type_of_id') == 'zim_id')) {
            $messages["national_id.regex"] = "National ID must taken the form 99-999999X99 there must be no spaces.";
        }

        $this->validate(\request(), $rules, $messages);

        $student = \DB::table("idwstudcard2016")->where("id", $card_id);

        $full_name = \request("full_name");
        $success = $student->update([
            "Account" => \request("national_id"),
            "Name" => $full_name,
            "ucARSTUDENTNO" => \request("student_no")
        ]);

//        if (!$success)
//            return back()->withInput()->withErrors("Failed to update the student's record, please try again.");

        return redirect()->route("staff.student-finder")->withStatus("You have successfully updated {$full_name}'s record. ");
    }

    public function studentFinder()
    {
//        $idcards = \DB::table('idwstudcard2016')->;
    }

    public function index()
    {
        $tickets = SupportTicket::with("ticketable")->whereNull("resolved_at")->orderBy("created_at", "asc")->paginate(15);
        return view("staff.support.index", compact('tickets'));
    }

    public function view($id)
    {
        $ticket = SupportTicket::with("ticketable")->find($id);
        if (is_null($ticket))
            return redirect()->route("staff.tickets");

        return view("staff.support.view", compact('ticket'));
    }

    public function respond(Request $request, $id)
    {
        $this->validate($request, [
            "description" => "required"
        ]);

        $ticket = SupportTicket::with("ticketable")->find($id);

        if (is_null($ticket))
            return redirect()->route("staff.tickets")->withErrors("Sorry, the ticket doesn't seem to exist!");

        if (is_null($ticket->ticketable->email))
            return back()->withErrors("Account doesn't have email.");

        $issue = collect(SupportTicket::$issue_types)->where("id", $ticket->issue_type)->first()["student_detail"];

        $data = ["user" => $ticket->ticketable, "message_description" => \request("description")];

        Mail::send('staff.support.email.support-email', $data, function ($message) use ($data, $issue) {
            $message->to($data["user"]->email, $data["user"]->name)->subject("Harare Polytechnic College Support: {$issue}.");
            $message->replyTo("hrepoly.help@gmail.com", "Harare Polytechnic Portal");
        });

        return back()->exceptInput()->withStatus("Your response has been sent!");
    }

    //Not For Staff Side
    public function create()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $plan = UserProfileUpdatePlan::whereUserId($user->id)->whereStatus('A')->first();
            if (is_null($plan))
                return back();
            return view("support.registered-user");
        }
        return view("support.unregistered-user");
    }

    public function storeUnregistered(Request $request)
    {
//        "first_name","surname","national_id","student_id","email","issue","description"
        $this->validate($request, [
            "first_name" => "required",
            "surname" => "required",
            "national_id" => "required",
            "student_id" => "required",
            "email" => "required|email",
            "issue" => "required"
        ]);

        $user = UnregisteredUser::firstOrCreate(["national_id" => \request("national_id"), "student_id" => \request("student_id")],
            $request->only(["first_name", "surname", "email"]));

        $user->tickets()->create(["issue_type" => \request("issue"), "description" => \request("description")]);
        return redirect()->route("login")->withSuccess("Your issue has been reported, you issue will be addressed within 24 hours. Check your email.");

    }

    public function storeRegistered(Request $request)
    {
        $user = User::find(auth()->id());
        $plan = UserProfileUpdatePlan::whereUserId($user->id)->whereStatus('A')->first();
        if (is_null($plan))
            return back();

        $this->validate($request, [
            "description" => "required"
        ]);

        $issue_stage = collect(SupportTicket::$issue_types)
            ->where("auth", 1)
            ->where("student_detail", "Stage {$plan->stage}")->first()["id"];

        $user->tickets()->create(["issue_type" => $issue_stage, "description" => \request("description")]);

        return redirect()->route($plan->route)->withStatus("Your issue has been reported, you issue will be addressed within 24 hours. Check your email.");
    }
}
