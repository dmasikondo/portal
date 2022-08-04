<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Hash;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token]
        );
    }

    public function reset(Request $request)
    {
        $this->validate($request, [
            'token' => "required",
            "national_id" => "required",
            "password" => "required|string|min:6|confirmed"
        ]);

        $token = $request->get('token');
        $reset_record = DB::table("password_resets")->where([
            "national_id" => strtoupper(\request("national_id")),
            "token" => $token])->first();

        if (is_null($reset_record)) {
            return back()->withErrors("Record not found in the system.");
        }

        $user = User::where("national_id", $reset_record->national_id)->first();

        $user->password = Hash::make(\request('password'));
        $user->save();

        DB::table("password_resets")->where([
            "national_id" => strtoupper(\request("national_id")),
            "token" => $token])->delete();

        return redirect()->route("login")
            ->with("success", "Your password was reset successfully! You may login with your new password");
    }
}
