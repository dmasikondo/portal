<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\ProfileBaseController;
use App\User;
use Illuminate\Http\Request;

class PersonalController extends ProfileBaseController
{
    public function create()
    {
        return view('profile.stage1');
    }

    public function store(Request $request)
    {
        $request->merge([
            'date_of_birth' =>
                $request->get('birth_year') . '-' . $request->get('birth_month') . '-' . $request->get('birth_day')
        ]);

        $regex = "/^([a-zA-Z'-]{2,}(\s?))+$/";

        $this->validate($request, [
            'title' => 'required|in:Mr,Mrs,Miss,Dr,Ms,Rev,Sr,Prof',
            'surname' => 'required|regex:' . $regex,
            'first_name' => 'required|regex:' . $regex,
            'gender' => 'required|in:MALE,FEMALE',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
            'height' => 'numeric|between:80,300',
            'mass' => 'numeric|min:20|max:300'
        ], [
            "date_of_birth.date_format" => "The :attribute is invalid.",
            'height.between' => 'The :attribute value :input is not between :min - :max centimeters.',
            'mass.min' => 'The :attribute value must be greater than :min kilograms.',
            'mass.max' => 'The :attribute value must be less than :max kilograms.',
            'first_name.regex' => "Please expand initials in your first name."
        ]);

        if ($request->get("title") == "Mr") {
            if ($request->get("gender") == "Female") {
                return back()->withInput()->withErrors("Please check gender and title fields and make the necessary adjustments.");
            }
        }

        $user = User::where(['id' => auth()->id()])->first();

        $first_names = explode(" ", $request->get("first_name"));
        foreach ($first_names as $first_name) {
            if (strlen($first_name) < 2)
                return back()->withInput()->withErrors("All first names must be provided in full.");
        }

        $user->update([
            "first_name" => strtoupper($request->get("first_name")),
            "last_name" => strtoupper($request->get("surname"))
        ]);

        $personal_info = $request->only(["title", "gender", "passport", "race", "height", "mass", "date_of_birth", "marital_status"]);

        $user->personalInformation()->updateOrCreate(["user_id" => auth()->id()], $personal_info);

//        return redirect()->route("ur.stage2");
        return $this->planProgression();
    }

}
