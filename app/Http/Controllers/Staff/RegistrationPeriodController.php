<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\SysRegistrationPeriod;
use Illuminate\Http\Request;

class RegistrationPeriodController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:staff_user");
    }

    public function index()
    {
        return view('staff.registration-period.index');
    }

    public function indexPeriod()
    {
        $registration_periods = SysRegistrationPeriod::orderBy('start_date', 'desc')
            ->orderBy('end_date', 'asc')
            ->paginate(15);
        return view('staff.registration-period.dates.index', compact('registration_periods'));
    }

    public function create()
    {
        return view('staff.registration-period.dates.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'start_date' =>
                $request->get('start_year') . '-' . $request->get('start_month') . '-' . $request->get('start_day')
        ]);

        $request->merge([
            'end_date' =>
                $request->get('end_year') . '-' . $request->get('end_month') . '-' . $request->get('end_day')
        ]);

        $this->validate($request, [
            "title" => "required",
            "start_date" => "required|date_format:Y-m-d",
            "end_date" => "required|date_format:Y-m-d"
        ]);

        SysRegistrationPeriod::create($request->only(['title', "start_date", "end_date"]));

        return redirect()->route('staff.registration.sessions.index')->withStatus("The registration period has been added!");
    }
}
