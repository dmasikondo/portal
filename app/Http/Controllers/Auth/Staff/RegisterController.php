<?php

namespace App\Http\Controllers\Auth\Staff;

use App\Http\Controllers\Controller;
use App\StaffUser;
use Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $recordsPerPage = 15;

    public function __construct()
    {
        $this->middleware(['auth:staff_user']);
    }

    public function index()
    {
        $users = $this->userModel();
        return view('staff.users.index', compact('users'));
    }

    public function create()
    {
        return view('staff.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:staff_users',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'user_type' => "required",
            "departments.*" => "required_if:user_type,enrolment_user|exists:department,id"
        ]);


        $array = $request->only(['first_name', 'last_name', 'username', 'email', 'user_type']);
        $array['password'] = Hash::make($request->get("password"));

        $staff_user = StaffUser::create($array);

        if (\request('user_type') == "enrolment_user") {
            $array = [];
            foreach (\request("departments") as $department) {
                $array[]["department_id"] = $department;
            }
            $staff_user->enrolmentPermissions()->createMany($array);
        }

        return redirect()->route('staff.users')->withStatus("The new user has been successfully added");
    }

    public function edit(StaffUser $user)
    {
        return view('staff.users.update', compact("user"));
    }

    public function update(Request $request, StaffUser $user)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:staff_users,username,' . $user->id,
            'email' => 'required|string|email|max:255',
            'password' => ((!is_null($request->get("password"))) ? 'string|min:6' : ""),
            'user_type' => "required",
            "departments.*" => "required_if:user_type,enrolment_user|exists:department,id"
        ]);

        $array = $request->only(['first_name', 'last_name', 'username', 'email', 'user_type']);

        if ($request->has("password"))
            $array["password"] = Hash::make($request->get("password"));

        $user->update($array);
        $user->enrolmentPermissions()->delete();

        if (\request('user_type') == "enrolment_user") {
            $array = [];
            foreach (\request("departments") as $department) {
                $array[]["department_id"] = $department;
            }
            $user->enrolmentPermissions()->createMany($array);
        }

        return redirect()->route('staff.users')->withStatus("{$user->name}'s account has been successfully updated");
    }

    public function destroy()
    {
        $this->validate(\request(), [
            "user_id" => "required|exists:staff_users,id"
        ]);

        if (\Auth::id() == \request("user_id"))
            return back()->withErrors("You can not delete your own account.");

        $user = StaffUser::find(\request("user_id"));

        $user->delete();

        return redirect()->route('staff.users')->withStatus("{$user->name}'s account has been deleted");
    }

    private function userModel()
    {
        $search_term = request('search');
        if (is_null($search_term))
            return StaffUser::where("id", "!=", \Auth::id())->paginate($this->recordsPerPage);

        return StaffUser::where("id", "!=", \Auth::id())
            ->where(function ($query) use ($search_term) {
                return $query->where("first_name", "LIKE", "%" . $search_term . "%")
                    ->orWhere("last_name", "LIKE", "%" . $search_term . "%")
                    ->orWhere("username", "LIKE", "%" . $search_term . "%")
                    ->orWhere("email", "LIKE", "%" . $search_term . "%");
            })->paginate($this->recordsPerPage);
    }
}
