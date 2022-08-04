<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\ProfileBaseController;
use App\User;
use Illuminate\Http\Request;

class OriginController extends ProfileBaseController
{
    public function create()
    {
        return view('profile.stage2');
    }

    public function store(Request $request)
    {
//        "nationality","birth_country","birth_town","hometown","race","religion","denomination"
        $this->validate($request, [
            "nationality" => "required|exists:countries,code",
            "birth_country" => "required|exists:countries,code",
            "birth_town" => "required",
            "hometown" => "required",
            "race" => 'required|in:Black,Asian,White',
            "religion" => 'required|in:Christianity,Islam,Hinduism,Traditional religions,Unspecified',
            "denomination" => "required"
        ]);

        $user = User::where(['id' => auth()->id()])->first();

        $origin = $request->only(["nationality", "birth_country", "birth_town", "hometown", "race", "religion", "denomination"]);

        $user->originInformation()->updateOrCreate(["user_id" => auth()->id()], $origin);

//        return redirect()->route('ur.stage3');
        return $this->planProgression();
    }

}
