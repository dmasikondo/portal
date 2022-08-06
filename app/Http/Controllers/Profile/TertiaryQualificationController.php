<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\ProfileBaseController;
use App\TertiaryQualification;
use App\TertiaryQualificationPeriod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TertiaryQualificationController extends ProfileBaseController
{
    public function index()
    {
        $qualifications = TertiaryQualification::whereUserId(\Auth::id())->get();
        return view('profile.tertiary-qualification', compact('qualifications'));
    }

    public function storeTertiaryEducation(Request $request)
    {
        $this->validate($request, [
            "institution_name" => "required",
            "qualification_title" => "required",
        ]);

        if (TertiaryQualification::whereUserId(\Auth::id())->where([
                "institution_name" => $request->get('institution_name'),
                "qualification_title" => $request->get('qualification_title')])->count() > 0)
            return back()->withErrors("You have entered this qualification before.");
        $code = "";
        do {
            $code .= str_random(30);
        } while (TertiaryQualification::whereCode($code)->count() > 0);

        $qualifications = $request->only("institution_name", "qualification_title");
        $qualifications["user_id"] = \Auth::id();
        $qualifications["code"] = $code;

        $tq = TertiaryQualification::create($qualifications);

        return redirect()->route("ur.addTertiaryPeriod", ["code" => $tq->code])->with("status", "Your Tertiary Qualification has been added!");

    }

    public function addTertiaryPeriod($code)
    {
        $qualification = TertiaryQualification::whereCode($code)->whereUserId(\Auth::id())->first();
        if (is_null($qualification))
            return redirect()->route('ur.addTertiary')
                ->withErrors("The record either doesn't exist or you are not authorized to view it.");

        return view('updaters.add-period', compact('qualification'));
    }

    public function storeTertiaryPeriod(Request $request, $code)
    {
        $qualification = TertiaryQualification::whereCode($code)->first();
        if (is_null($qualification) || $qualification->user_id != \Auth::id())
            return back()->withErrors("The record either doesn't exist or you are not authorized to update it.");

        $this->validate($request, [
            "period" => ["required", Rule::unique("tertiary_qualification_period")->where(function ($query) use ($qualification) {
                return $query->where('tertiary_qualification_id', $qualification->id);
            })],
            "number_of_courses" => "required|min:1|max:25",
        ], [
            "period.unique" => "A period with the same title has already been added to this qualification."
        ]);

        $period = $qualification->periods()->create($request->only(["period", "number_of_courses"]));

        return redirect()
            ->route('ur.addTertiaryPeriodResults', ["code" => $code, "id" => base64_encode($period->id)])
            ->with("status", "The period has been added to your qualification.");
    }

    public function addTertiaryPeriodResults($code, $id)
    {
        $qualification = TertiaryQualification::whereCode($code)->first();
        $period = TertiaryQualificationPeriod::withCount("results")
            ->whereTertiaryQualificationId($qualification->id)
            ->whereId(base64_decode($id))->first();

        if (is_null($qualification) || $qualification->user_id != \Auth::id() || is_null($period))
            return redirect()
                ->route('ur.addTertiary')
                ->withErrors("The record either doesn't exist or you are not authorized to update it.");

        if ($period->results_count > 0)
            return redirect()
                ->route('ur.addTertiary')
                ->withErrors("The period already has results.");

        return view('updaters.add-period-results', compact('qualification', 'period'));
    }

    public function storeTertiaryPeriodResults(Request $request, $code, $id)
    {
        $qualification = TertiaryQualification::whereCode($code)->first();
        $period = TertiaryQualificationPeriod::withCount("results")
            ->whereTertiaryQualificationId($qualification->id)
            ->whereId(base64_decode($id))->first();

        if (is_null($qualification) || $qualification->user_id != \Auth::id() || is_null($period))
            return redirect()
                ->route('ur.addTertiary')
                ->withErrors("The record either doesn't exist or you are not authorized to update it.");

        if ($period->results_count > 0)
            return redirect()
                ->route('ur.addTertiary')
                ->withErrors("The period already has results.");

        $this->validate($request, [
            "cert.*.course" => "required",
            "cert.*.grade" => "required"
        ], [
            "cert.*.course.required" => "Each course field must be filled in",
            "cert.*.grade.required" => "Each course must have a grade."
        ]);

        $grades = $request->only('cert')['cert'];

        foreach ($grades as $key => $value) {
            $grades[$key]["module"] = ucwords(strtolower($value["course"]));
        }

        $courses = $this->array_not_unique(collect($grades)->pluck("module")->toArray());

        if (count($courses) > 0)
            return back()->withInput()->withErrors("There were duplicate courses, please correct your period results");

        $period->results()->createMany($grades);

        $statusMsg = "The period results have been added to your qualification.";
        if ($request->has("save_add"))
            return redirect()
                ->route("ur.addTertiaryPeriod", ["code" => $code])
                ->with("status", $statusMsg);

        return redirect()->route("ur.addTertiary")->with("status", $statusMsg . " Fill in the form below to add another period.");
    }

    public function proceed()
    {
        $tertiary_qualification = TertiaryQualification::with("periods.results")->whereUserId(\Auth::id())->get();

        foreach ($tertiary_qualification as $tertiary) {
            if ($tertiary->periods->count() < 1) {
                return back()->withErrors("Please add an academic period to all your qualifications to proceed..");
            }

            foreach ($tertiary->periods as $period) {
                if ($period->results->count() < 1) {
                    return back()->withErrors("Please provide results for all academic periods on your tertiary qualifications to proceed.");
                }
            }
        }

//        return redirect()->route('ur.stage5');
        return $this->planProgression();
    }

    public function confirmDeleteTertiary($code)
    {
        $item = TertiaryQualification::with("periods.results")->whereUserId(\Auth::id())->whereCode($code)->first();

        if (is_null($item))
            return redirect()
                ->route('ur.addTertiary')
                ->withErrors("The record either doesn't exist or you are not authorized to update it.");

        return view('updaters.delete-tertiary', compact('item'));
    }

    public function deleteTertiary(Request $request, $code)
    {
        $item = TertiaryQualification::whereUserId(\Auth::id())->whereCode($code)->first();

        $this->validate($request, [
            'item_to_delete' => 'required'
        ]);

        $toDel = \request('item_to_delete');

        $thing = (($toDel != "all" && !is_numeric($toDel)));

        if (is_null($item) || $thing)
            return redirect()
                ->route('ur.addTertiary')
                ->withErrors("The record either doesn't exist or you are not authorized to update it.");

        if ($toDel == "all") {
            foreach ($item->periods as $period) {
                $period = TertiaryQualificationPeriod::where('tertiary_qualification_id', $item->id)->whereId($period->id)->first();
                if (!is_null($period)) {
                    $period->results()->delete();
                    $period->delete();
                }
            }
            $item->delete();
        }

        if (is_numeric($toDel)) {
            $period = TertiaryQualificationPeriod::where('tertiary_qualification_id', $item->id)->whereId($toDel)->first();
            if (!is_null($period)) {
                $period->results()->delete();
                $period->delete();
            }
        }

        return redirect()
            ->route('ur.addTertiary')
            ->withStatus("The record has been deleted successfully.");
    }


}
