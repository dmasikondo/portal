<?php

namespace App\Http\Controllers;

use App\User;
use App\UserProfileUpdatePlan;

class ProfileBaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'profile.update.off']);
    }

    public function planProgression()
    {
        $plan = $this->activePlan();

        if (is_null($plan))
            return redirect()->route("home");

        if ($plan->stage == $plan->total_stages) {
            User::whereId(auth()->id())->update(["update_record" => "N"]);
            UserProfileUpdatePlan::whereUserId(auth()->id())->delete();
            return redirect()->route('home')->with('status', "Your account details have been updated");;
        } else {
            $plan->update(["status" => "C"]);
            $new_stage_no = $plan->stage;

            do {
                $new_stage_no++;
                $new_stage = UserProfileUpdatePlan::whereUserId(auth()->id())->whereStage($new_stage_no)->first();
            } while (is_null($new_stage) && $new_stage_no <= $plan->total_stages);

            $new_stage->update(["status" => "A"]);
            return redirect()->route($new_stage->route);
        }
    }

    public function activePlan()
    {
        return UserProfileUpdatePlan::whereUserId(auth()->id())->whereStatus('A')->first();
    }

    public function array_not_unique($raw_array)
    {
        $dupes = array();
        natcasesort($raw_array);
        reset($raw_array);

        $old_key = NULL;
        $old_value = NULL;
        foreach ($raw_array as $key => $value) {
            if ($value === NULL) {
                continue;
            }
            if (strcasecmp($old_value, $value) === 0) {
                $dupes[$old_key] = $old_value;
                $dupes[$key] = $value;
            }
            $old_value = $value;
            $old_key = $key;
        }
        return $dupes;
    }

    public function removePrefix(array $input, $prefix)
    {
        $return = array();
        foreach ($input as $key => $value) {
            if (strpos($key, $prefix) === 0)
                $key = substr($key, strlen($prefix));

            if (is_array($value))
                $value = removePrefix($value);

            $return[$key] = $value;
        }
        return $return;
    }

    public function toUpper($matches)
    {
        return strtoupper($matches[1]);
    }

    public function slugToCamel($string)
    {
        return preg_replace_callback('/[-_](.)/', [$this, 'toUpper'], $string);
    }
}
