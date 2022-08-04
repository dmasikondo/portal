<?php

namespace App\Http\Controllers\Staff;

use App\Bed;
use App\Hostel;
use App\Http\Controllers\Controller;
use App\PastelAccountName;
use App\ResidenceSpace;
use App\StudentResidenceAllocation;
use App\Transaction;
use App\User;
use Carbon\Carbon;

class AccommodationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:staff_user");
    }

    public function index()
    {
        $hostels = Hostel::get();
        return view("staff.accomodation.main-index", compact('hostels'));
    }

    public function indexHostels()
    {
        $hostels = Hostel::paginate();
        return view('staff.accomodation.index', compact('hostels'));
    }

    public function indexHostelRooms(Hostel $hostel)
    {
        $res_space = ResidenceSpace::whereRaw("start_date <= NOW() AND end_date >= NOW()")->first();
        $hostels = Hostel::get();
        if (is_null($res_space)) {
            return back()->withErrors("No active residence space.");
        }
        $hostel->load(["rooms.beds.student_residence_allocation" => function ($q) use ($res_space) {
            return $q->whereResidenceSpaceId($res_space->id);
        }, "rooms.beds.student_residence_allocation.user"]);

        return view("staff.accomodation.room-index", compact("hostels", "hostel"));
    }

    public function searchStudent($bed_id)
    {
        $bed = Bed::with(["room.hostel", "student_residence_allocation"])->find($bed_id);
//        $bed = Bed::find($bed_id);

        return view("staff.accomodation.search-student", compact("bed"));
    }

    public function showStudentProfile($bed_id)
    {
        $res_space = ResidenceSpace::whereRaw("start_date <= NOW() AND end_date >= NOW()")->first();

        if (is_null($res_space)) {
            return back()->withErrors("No active residence space.");
        }

        $this->validate(request(), [
            "student_no" => "required|exists:users,student_no"
        ]);

        $user = User::with(["personalInformation", "studentResidenceAllocation" => function ($q) use ($res_space) {
            $q->whereResidenceSpaceId($res_space->id);
        }])->whereStudentNo(request("student_no"))->first();

        if (!is_null($user->studentResidenceAllocation)) {
            return back()->withErrors("Student was already allocated a room.");
        }


        $bed = Bed::whereDoesntHave("student_residence_allocation", function ($q) use ($res_space) {
            $q->whereResidenceSpaceId($res_space->id);
        })->with("room.hostel")->find($bed_id);

        $transactions = Transaction::whereAccountNumber(PastelAccountName::find($user->national_id)->Account)
            ->select(\DB::raw("(sum(Debit)-sum(Credit)) as acc_balance"))
            ->first();

        return view("staff.accomodation.view-student-profile", compact('user', 'bed', 'transactions'));
    }

    public function allocateBed($bed_id, User $user)
    {
        $res_space = ResidenceSpace::whereRaw("start_date <= NOW() AND end_date >= NOW()")->first();

        $user->load(["personalInformation"]);

        $bed = Bed::with(["room", "student_residence_allocation" => function ($q) use ($res_space) {
            return $q->whereResidenceSpaceId($res_space->id);
        }])->find($bed_id);

        if (strtoupper($bed->room->gender) != strtoupper($user->personalInformation->gender)) {
            return redirect()->route("staff.accommodation.search-student", ["bed_id" => $bed->id])
                ->withErrors("Student cannot be allocated to a {$bed->room->gender} room.");
        }

        if (!is_null($bed->student_residence_allocation)) {
            return redirect()->route("staff.accommodation.hostel-rooms", ["hostel" => $bed->room->hostel_id])
                ->withErrors("Bed has already been allocated to another student.");
        }

        $allocation = StudentResidenceAllocation::create([
            "user_id" => $user->id, "bed_id" => $bed->id,
            "residence_space_id" => $res_space->id, "allocation_date" => Carbon::today()
        ]);

        return redirect()->route("staff.accommodation.allocate-student.complete", ["allocation" => $allocation->id]);
    }

    public function allocationComplete(StudentResidenceAllocation $allocation)
    {
        $allocation->load(["user", "bed.room.hostel", "residence_space"]);
        return view("staff.accomodation.complete", compact("allocation"));
    }
}
