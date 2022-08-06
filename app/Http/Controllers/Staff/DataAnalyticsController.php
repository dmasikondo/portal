<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\StudentRegistration;
use App\SysRegistrationPeriod;

class DataAnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:staff_user");
    }

    public function index()
    {
        return view("staff.data-analytics.index");
    }

    public function viewFinancial($status)
    {
        if (!in_array($status, ["paid", "owing"]))
            return back();

        $current_period = SysRegistrationPeriod::whereRaw("start_date <= NOW() AND end_date >= NOW()")->first();

        if (is_null($current_period)) {
            return back()->withErrors("There is no active period on the system at the moment.");
        }

        $student_ids = StudentRegistration::with("student_enrolment")->whereRegistrationPeriodId($current_period->id)->get()->pluck("student_enrolment.userid");

        $id_list = "(" . implode(",", $student_ids->toArray()) . ")";


        if ($status == "owing") {
            $sign = ">";
        } else {
            $sign = "<=";
        }


        $students = \DB::select("SELECT u.id, u.student_no, u.first_name, u.last_name, trans.balance FROM 
              (users u join pastel_account_names pan ON u.national_id = pan.national_id) join 
              (SELECT account_number, (SUM(debit) - SUM(credit)) as balance FROM `transaction` GROUP BY account_number) 
              trans ON pan.Account = trans.account_number WHERE u.id IN {$id_list} AND trans.balance {$sign} 0");

        return view("staff.data-analytics.view-transactions", compact('students', "status"));
    }
}
