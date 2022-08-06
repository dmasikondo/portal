<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\ProfileBaseController;
use App\User;
use Illuminate\Http\Request;

class ContactController extends ProfileBaseController
{
    private $regex_phone = "/^(\\+(\\d{1,3}))?[-. (]*(\\d{3})[-. )]*(\\d{3})[-. ]*(\\d{4})(?: *x(\\d+))?\\s*$/";

    public function create()
    {
        return view('profile.stage3');
    }

    public function store(Request $request)
    {
        $rule = [
            "house_number" => "required",
            "street_name" => "required",
            "suburb" => "required",
            "city" => "required",
            "country" => "required|exists:countries,code",
        ];

        if (is_null(\Auth::user()->contactInformation)) {
            $rule["cellphone"] = "required|regex:{$this->regex_phone}";
            $rule["email"] = "required|email";
        }


        $this->validate($request, $rule);

        $user = User::whereId(\Auth::id());

        $fields = ["house_number", "street_name", "suburb", "city", "country"];
        if (is_null(\Auth::user()->contactInformation)) {
            $fields[] = "cellphone";
            $fields[] = "email";
        }
        $contact = $request->only($fields);

        if (isset($contact["email"])) {
            $contact["email"] = strtolower($contact["email"]);
            $user->update(["email" => $contact["email"]]);
        }

        $user = $user->first();

        $user->contactInformation()->updateOrCreate(["user_id" => auth()->id()], $contact);

//        return redirect()->route('ur.stage4');
        return $this->planProgression();
    }

    public function updateContacts($attribute)
    {
        $attribute = $this->slugToCamel("update-" . $attribute);

        if (method_exists($this, $attribute))
            return $this->$attribute();

        abort(404);
    }

    public function updatePhoneNumber()
    {
        $this->validate(\request(), [
            "cellphone" => "required|regex:{$this->regex_phone}",
        ]);

        $contact = \request()->only(["cellphone"]);

        User::whereId(\Auth::id())->first()->contactInformation()->update($contact);

        return redirect()->route("ur.verifyStudent")->withStatus("You have successfully updated your phone number.");

    }

    public function updateEmail()
    {
        $this->validate(\request(), [
            "email" => "required|email",
        ]);

        $contact = \request()->only(["email"]);

        $user = User::whereId(\Auth::id());

        $user->update(["email" => $contact["email"]]);

        User::whereId(\Auth::id())->first()->contactInformation()->update($contact);

        return redirect()->route("ur.verifyStudent")->withStatus("You have successfully updated your e-mail.");

    }

}
