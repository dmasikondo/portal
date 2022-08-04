<?php

namespace App\Http\Controllers;

use App\SocialUser;
use Auth;
use Socialite;

class SocialAuthController extends Controller
{
    public function getSocialRedirect($account)
    {
//        try {
//            return Socialite::with($account)->redirect();
//        } catch (\InvalidArgumentException $e) {
//            return back()->withErrors("The selected authentication method is currently not available.");
//        }
    }

    public function getSocialCallback($account)
    {
//        $socialUser = Socialite::with($account)->user();
//
//        if (Auth::guest()) {
//            $s_user = SocialUser::where('provider_id', '=', $socialUser->id)
//                ->where('provider', '=', $account)
//                ->first();
//
//            if (is_null($s_user)) {
//                return redirect()->route("lhome")
//                    ->withErrors("Please create your student account before attempting to login.");
//            }
//
//            if (Auth::loginUsingId($s_user->user_id) === false) {
//                return redirect()->route("lhome")->withErrors("Failed to login using your {$account} account. Please try again");
//            }
//
//            return redirect()->route('home');
//        } else {
//            $s_user = SocialUser::firstOrCreate([
//                "provider" => $account,
//                "provider_id" => $socialUser->getId()],
//                [
//                    "user_id" => Auth::id()
//                ]);
//
//            return redirect()->route('ur.verifyStudent')
//                ->with("status", "Your {$account} account has been linked to your Harare Polytechnic account.");
//        }
    }
}
