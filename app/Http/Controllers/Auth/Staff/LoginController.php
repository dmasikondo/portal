<?php

namespace App\Http\Controllers\Auth\Staff;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/student-management/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:staff_user')->except('logout');
        $this->redirectTo = route('staff.home');
    }

    public function showLoginForm()
    {
        return view('auth.staff.login');
    }

    public function username()
    {
        return 'username';
    }

    protected function guard()
    {
        return Auth::guard('staff_user');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->user_type == "enrolment_user") {
            return redirect()->route('staff.students.enrolment');
        }
    }
}
