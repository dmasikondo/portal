<?php

namespace App\Http\Controllers;

use App\ContactInformation;
use App\PastelAccountName;
use App\PersonalInformation;
use App\StudentEnrolment;
use App\Transaction;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'check.update']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $personal = PersonalInformation::whereUserId($user->id)->first();
        $contacts = ContactInformation::whereUserId($user->id)->first();
        $enrolment = StudentEnrolment::with(["qualification", "programme"])->whereUserid($user->id)->get();
        $pastel = PastelAccountName::find($user->national_id);
        $account_number = (is_null($pastel)) ? $user->national_id : $pastel->Account;
        $transactions = Transaction::whereAccountNumber($account_number)->get();
//        $balance = Transaction::select(\DB::raw("SUM(debit)+(-SUM(credit)) as `balance`"))
//            ->whereAccountNumber($user->national_id)->first()->balance;


        return view('home', compact("user", "personal", "contacts", "enrolment", "transactions"));
    }
}
