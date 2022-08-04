<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, [
            "national_id" => "required",
            "email" => "required|email"
        ]);

        $national_id = strtoupper($request->get("national_id"));
        $user = User::where(["national_id" => $national_id, "email" => $request->get("email")])->first();

        if (!is_null($user)) {
            $token = str_random(40);

            DB::table("password_resets")->updateOrInsert(
                ["national_id" => $national_id,],
                ["token" => $token]);

            $data = ["route" => route("password.reset", ["token" => $token]), "user" => $user];

            Mail::send('auth.email.password-reset', $data, function ($message) use ($data) {
                $message->to($data["user"]->email, $data["user"]->name)->subject('Harare Polytechnic College Password Reset.');
            });

            return back()->with('success', "An email has been sent to you with further instructions.");
        }
        return back()->withInput()->withErrors("Account was not found! Please verify your details.");
    }
}
