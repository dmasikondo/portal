<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\ProfileBaseController;
use App\SecondaryExamCertificate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;

class SecondaryExamController extends ProfileBaseController
{

    public function createCertificate()
    {
        return view('updaters.add-certificate');
    }

    public function storeCertificate(Request $request)
    {
        $this->validate($request, [
            'month' => "required|date_format:m",
            'year' => "required|date_format:Y",
            "level" => "required|in:O,A",
            "examining_body" => "required|in:ZIMSEC,CAMBRIDGE",
            "center_number" => "required",
            "candidate_number" => "required",
            "certificate_number" => "required|unique:secondary_exam_certificates,certificate_number",
            "number_of_subjects" => "required|min:1|max:20"
        ], [
            "center_number.required" => "The centre name field is required."
        ]);

        $cert_details = $request->only('level', 'examining_body', "center_number", "candidate_number", 'certificate_number', "number_of_subjects");
        $cert_details["result_year"] = $request->get('year');
        $cert_details["result_month"] = Carbon::createFromFormat("m", $request->get('month'))->englishMonth;

        $user = User::where(['id' => auth()->id()])->first();
        $certs = $user->secondaryExamCertificates()->create($cert_details);

        \session(["subjectCount-{$certs->id}",]);

        return redirect()->route('ur.addCertificateResults', ["id" => base64_encode($certs->id)]);
    }

    public function addCertificateResults($id)
    {
        $certs = SecondaryExamCertificate::find(base64_decode($id));

        if (is_null($certs) || $certs->user_id != auth()->id() || !is_numeric(base64_decode($id)))
            return redirect()->route('ur.secodarySchool')->withErrors("The record either doesn't exist or you aren't allowed to access it.");

        if ($certs->results->count() > 0)
            return redirect()->route('ur.secodarySchool')->withErrors("The certificate already has subjects.");

        return view('updaters.add-certificate-results', compact('certs'));
    }

    public function storeCertificateResults(Request $request, $id)
    {
        $certs = SecondaryExamCertificate::find(base64_decode($id));

        if (is_null($certs) || $certs->user_id != auth()->id() || !is_numeric(base64_decode($id)))
            return redirect()->route('ur.secodarySchool')->withErrors("The record either doesn't exist or you aren't allowed to access it.");

        if ($certs->results->count() > 0)
            return redirect()->route('ur.secodarySchool')->withErrors("The certificate already has subjects.");

        if ($request->has("missing_subject")) {
            $this->validate($request, [
                "subject" => "required"
            ]);
            \DB::table('secondary_subject_list')
                ->insert(["level" => $certs->level, "board" => $certs->examining_body, "subject" => strtoupper(\request("subject"))]);
            Log::info(json_encode(["user_id" => $certs->user_id, "subject" => strtoupper(\request("subject"))]));
            return redirect()->route("ur.addCertificateResults", ["id" => $id])->withStatus("The subject suggestion has submitted and will be reviewed and added!");
        }

        $this->validate($request, [
            "cert.*.subject" => "required",
            "cert.*.grade" => "required|in:A,B,C,D,E,U,F,O"
        ], [
            "cert.*.subject.required" => "Each subject field must be filled in",
            "cert.*.grade.required" => "Each subject must have a grade."
        ]);

        $grades = $request->only('cert')['cert'];

        foreach ($grades as $key => $value) {
            $grades[$key]["subject"] = ucwords(strtolower($value["subject"]));
        }

        $subjects = $this->array_not_unique(collect($grades)->pluck("subject")->toArray());

        if (count($subjects) > 0)
            return back()->withInput()->withErrors("There were duplicate subjects, please correct your certificate");

        $certs->results()->createMany($grades);

        return redirect()->route('ur.secodarySchool')->withStatus("The certificate has been successfully added.");
    }

    public function confirmDeleteCertificate($id)
    {
        $result = SecondaryExamCertificate::find(base64_decode($id));

        if (is_null($result) || $result->user_id != auth()->id() || !is_numeric(base64_decode($id)))
            return redirect()->route('ur.secodarySchool')->withErrors("The record either doesn't exist or you aren't allowed to access it.");

        return view('updaters.delete-certificate', compact('result'));
    }

    public function removeCertificate(Request $request)
    {
        $this->validate($request, [
            'certificate' => "required|exists:secondary_exam_certificates,id"
        ]);

        $result = SecondaryExamCertificate::find(\request('certificate'));

        if (is_null($result) || $result->user_id != auth()->id() || !is_numeric(\request('certificate')))
            return redirect()->route('ur.secodarySchool')->withErrors("The record either doesn't exist or you aren't allowed to access it.");

        $result->delete();

        return redirect()->route("ur.secodarySchool")->with('status', "The certificate has been deleted!");
    }

}
