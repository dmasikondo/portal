<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\ProfileBaseController;
use Auth;
use Illuminate\Http\Request;

class NextOfKinController extends ProfileBaseController
{

    public function addNextOfKin()
    {
        return view('profile.next-of-kin');
    }

    public function storeNextOfKin(Request $request)
    {
        $request->merge([
            'next_of_kin_date_of_birth' =>
                $request->get('birth_year') . '-' . $request->get('birth_month') . '-' . $request->get('birth_day')
        ]);

        $regex_name = "/^([a-zA-Z'-]{2,}(\s?))+$/";

        $regex_phone = "/^(\\+(\\d{1,3}))?[-. (]*(\\d{3})[-. )]*(\\d{3})[-. ]*(\\d{4})(?: *x(\\d+))?\\s*$/";

        $regex_national_id = "/^(([0-9]{2})([\-])([0-9]{6,})([A-Z]{1})([0-9]{2}))$/";

        $this->validate($request, [
            'next_of_kin_title' => 'required|in:Mr,Mrs,Miss,Dr,Ms,Rev,Sr,Prof',
            "next_of_kin_first_names" => "required|regex:" . $regex_name,
            "next_of_kin_surname" => "required|regex:" . $regex_name,
            "next_of_kin_relationship" => "required|exists:next_of_kin_relationships,id",
            "next_of_kin_gender" => 'required|in:Male,Female',
            'next_of_kin_date_of_birth' => 'required|date_format:Y-m-d',
            "next_of_kin_national_id" => "required|regex:" . $regex_national_id,
            "next_of_kin_cellphone" => "required|regex:{$regex_phone}",
            "next_of_kin_email" => "email",
            "next_of_kin_house_number" => "required",
            "next_of_kin_street_name" => "required",
            "next_of_kin_suburb" => "required",
            "next_of_kin_city" => "required",
            "next_of_kin_country" => "required|exists:countries,code"
        ],
            [
                "next_of_kin_national_id.regex" => "Your next of kin national id has an invalid format, the format is 99-999999X99."
            ]);

        $user = User::whereId(Auth::id())->first();

        if ($user->national_id == $request->get("next_of_kin_national_id")) {
            return back()->withInput()->withErrors("Your Next of Kin's National ID must not be the same as yours.");
        }

        $nok_contact = $this->removePrefix($request->only(["next_of_kin_surname", "next_of_kin_cellphone", "next_of_kin_date_of_birth",
            "next_of_kin_national_id", "next_of_kin_email", "next_of_kin_house_number", "next_of_kin_street_name", "next_of_kin_gender",
            "next_of_kin_suburb", "next_of_kin_city", "next_of_kin_country", "next_of_kin_title"]), "next_of_kin_");

        $nok_contact["name"] = strtoupper($request->get("next_of_kin_first_names"));
        $nok_contact["surname"] = strtoupper($nok_contact["surname"]);
        $nok_contact["next_of_kin_relationship_id"] = $request->get("next_of_kin_relationship");

        $user->nextOfKinInformation()->updateOrCreate(["user_id" => auth()->id()], $nok_contact);

        return $this->planProgression();
    }
}
