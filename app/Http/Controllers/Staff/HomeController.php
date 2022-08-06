<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:staff_user']);
    }

    public function home()
    {
        $completedByDays = \DB::select("SELECT COUNT(*) As Update_Completed, DAYNAME(updated_at) AS days, DATE(updated_at) AS dates FROM users WHERE update_record = 'N' AND 
        DATE_SUB(NOW(), INTERVAL 7 DAY) <= DATE(updated_at) 
        GROUP BY DATE(updated_at), DAYNAME(updated_at) ORDER BY dates ASC");

        $stageQuantities = \DB::select("SELECT stage, COUNT(*) as students_count FROM `user_profile_update_plans` WHERE `status` =\"A\" GROUP by stage");

        $totalCompletedRegistrations = \DB::select("SELECT COUNT(*) As Update_Completed FROM users WHERE update_record = 'N'");

        $dailyAverageRegistrations = \DB::select("SELECT AVG(cbd.Update_Completed) as avg_done FROM (
SELECT COUNT(*) As Update_Completed, DATE(updated_at) AS dates FROM users WHERE update_record = 'N' AND DATE_SUB(NOW(),
 INTERVAL 7 DAY) <= DATE(updated_at) GROUP BY DATE(updated_at) ORDER BY dates ASC
) cbd;");

        $userCount = \DB::select("SELECT COUNT(*) as users_count FROM users");

        $enrolledCountByDepartments = \DB::select("SELECT	department.`name`, COUNT(base_enrolled_students.id) AS `count`FROM base_enrolled_students 
RIGHT JOIN (programme RIGHT JOIN department ON programme.departmentid = department.id) ON base_enrolled_students.programmeid = programme.id 
GROUP BY department.`name`");

        $enrolmentPerDays = \DB::select("SELECT COUNT(id) As enrolled, DAYNAME(created_at) AS days, DATE(created_at) AS 'dates' FROM base_enrolled_students WHERE DATE_SUB(NOW(),
 INTERVAL 7 DAY) <= DATE(created_at) GROUP BY DATE(created_at), DAYNAME(created_at) ORDER BY `dates` ASC");

        return view('staff.dashboard', compact(
            'completedByDays', 'stageQuantities', 'totalCompletedRegistrations',
            'dailyAverageRegistrations', 'userCount', 'enrolledCountByDepartments', 'enrolmentPerDays'));
    }

    public function changePassword()
    {
        return view("staff.passwords.change-password");
    }

    public function processChangePassword()
    {
        $this->validate(request(), [
            "current_password" => "required",
            "new_password" => "required|string|min:6|max:16|confirmed",
        ]);

        if (!auth("staff_user")->attempt(["username" => auth()->user()->username, "password" => request("current_password")])) {
            return back()->withErrors("The current password you provided is incorrect. Please try again.");
        }

        auth()->user()->update(["password" => \Hash::make(request("new_password"))]);
        return back()->withStatus("Your password has been successfully updated!");
    }
}
