@extends("layouts.staff-master")

@section("pageTitle","Student Record")

@section("headerTitle","Student Record")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">
                            <a href="{{route("staff.students")}}" class="btn btn-icon btn-light mr-1"><i
                                    class="la la-chevron-circle-left"></i></a>
                            Student Record
                        </h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified mb-2">
                            <li class="nav-item">
                                <a class="nav-link active" id="active-tab" data-toggle="tab" href="#personal_data"
                                   aria-controls="active"
                                   aria-expanded="true">Personal Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="link1-tab" data-toggle="tab" href="#academic_data"
                                   aria-controls="link"
                                   aria-expanded="false">Academic Record</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="link2-tab" data-toggle="tab" href="#sponsor_data"
                                   aria-controls="link"
                                   aria-expanded="false">Sponsor Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="link3-tab" data-toggle="tab" href="#current_data"
                                   aria-controls="link"
                                   aria-expanded="false">Transactions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="link4-tab" data-toggle="tab" href="#manage_account"
                                   aria-controls="link"
                                   aria-expanded="false">Manage Account</a>
                            </li>
                            {{--<li class="nav-item">--}}
                            {{--<a class="nav-link" id="linkOpt-tab" data-toggle="tab" href="#linkOpt"--}}
                            {{--aria-controls="linkOpt">Another Link</a>--}}
                            {{--</li>--}}
                        </ul>
                        @include("layouts.partials.notifications")
                    </div>
                </div>

            </div>
            <div class="tab-content px-1 pt-1">
                <div class="tab-pane active" id="personal_data" role="tabpanel" aria-labelledby="active-tab"
                     aria-expanded="true">

                    <div class="row match-height">
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Student Stat</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal form-bordered">
                                            <div class="form-body">

                                                <div class="form-group row">
                                                    <label class="col-md-6 label-control">Account Created</label>
                                                    <div class="col-md-6">
                                                        {{$user->created_at}}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-6 label-control">Is Profile Update
                                                        Complete</label>
                                                    <div class="col-md-6">
                                                        {{($user->update_record=="Y")?"No":"Yes"}}
                                                    </div>
                                                </div>

                                                @if($user->update_record=="Y" && !is_null($user->userProfileUpdatePlan))
                                                    <?php
                                                    $activeStage = $user->userProfileUpdatePlan->where('status', 'A')->first();
                                                    ?>
                                                    <div class="form-group row">
                                                        <label class="col-md-6 label-control">Current Stage</label>
                                                        <div class="col-md-6">
                                                            {{(!is_null($activeStage))?$activeStage->stage:"-"}}
                                                        </div>
                                                    </div>
                                                @endif

                                                @php($balance = $transactions->sum("debit")+(-$transactions->sum("credit")))
                                                <div class="form-group row">
                                                    <label class="col-md-6 label-control">Student Account
                                                        Balance</label>
                                                    <div class="col-md-6">
                                                        {{($balance<0)?"-":""}}${{abs($balance)}}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-6 label-control">Current Course</label>
                                                    <div class="col-md-6">
                                                        @foreach($enrolment as $enrol)
                                                            <h5 class="text-capitalize">{{$enrol->programme->name}}
                                                                - {{$enrol->qualification->name}}</h5>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-6 label-control">Update Account</label>
                                                    <div class="col-md-6">
                                                        <a href="{{route("staff.student.personal-edit",["user"=>$user->id])}}"
                                                           class="btn btn-secondary">Open Updater</a>
                                                    </div>
                                                </div>

                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Personal Information</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">

                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @php($personal = $user->personalInformation)
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control"
                                                   for="form_control_1">National ID</label>
                                            <div class="col-md-7">
                                                {{$user->national_id}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control"
                                                   for="form_control_1">Student ID</label>
                                            <div class="col-md-7">
                                                {{(!is_null($user->student_no))?$user->student_no : "-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Title</label>
                                            <div class="col-md-7">
                                                {{(!is_null($personal))?$personal->title:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Surname</label>
                                            <div class="col-md-7">
                                                {{$user->last_name}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">First name</label>
                                            <div class="col-md-7">
                                                {{$user->first_name}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row match-height">
                        @php($origin = $user->originInformation)
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Contact Information</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">

                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @php($contact = $user->contactInformation)
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Cellphone</label>
                                            <div class="col-md-7">
                                                {{(!is_null($contact))?$contact->cellphone:"-"}}
                                                @if(!is_null($contact) && !is_null($user->contactVerification))
                                                    @if(!is_null($user->contactVerification->sms_verified_at))
                                                        <div class="badge badge-success">Verified</div>
                                                    @else
                                                        <div class="badge badge-secondary">Unverified</div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">E-mail</label>
                                            <div class="col-md-7">
                                                {{(!is_null($contact))?$contact->email:"-"}}
                                                @if(!is_null($contact) && !is_null($user->emailVerification))
                                                    @if(!is_null($user->emailVerification->email_verified_at))
                                                        <div class="badge badge-success">Verified</div>
                                                    @else
                                                        <div class="badge badge-secondary">Unverified</div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">House Number</label>
                                            <div class="col-md-7">
                                                {{(!is_null($contact))?$contact->house_number:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Street</label>
                                            <div class="col-md-7">
                                                {{(!is_null($contact))?$contact->street_name:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Suburb</label>
                                            <div class="col-md-7">
                                                {{(!is_null($contact))?$contact->suburb:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">City</label>
                                            <div class="col-md-7">
                                                {{(!is_null($contact))?$contact->city:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Country</label>
                                            <div class="col-md-7">
                                                {{(!is_null($contact))?$contact->country:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Hometown</label>
                                            <div class="col-md-7">
                                                {{(!is_null($origin))?($origin->hometown?:"-"):"-"}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Personal Information</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">

                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Nationality</label>
                                            <div class="col-md-7">
                                                {{(!is_null($origin))?$origin->nationality:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Passport</label>
                                            <div class="col-md-7">
                                                {{(!is_null($personal))?($personal->passport?:"-"):"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Birth Town</label>
                                            <div class="col-md-7">
                                                {{(!is_null($origin))?($origin->birth_town?:"-"):"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Birth Country</label>
                                            <div class="col-md-7">
                                                {{(!is_null($origin))?($origin->birth_country?:"-"):"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">DOB</label>
                                            <div class="col-md-7">
                                                {{(!is_null($personal))?$personal->date_of_birth:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Marital Status</label>
                                            <div class="col-md-7">
                                                {{(!is_null($personal))?$personal->marital_status:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Height</label>
                                            <div class="col-md-7">
                                                {{(!is_null($personal))?$personal->height:"-"}} cm(s)
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Weight</label>
                                            <div class="col-md-7">
                                                {{(!is_null($personal))?$personal->mass:"-"}} kg(s)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row match-height">
                        @php($origin = $user->originInformation)
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Ethnicity And Religion</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">

                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Race</label>
                                            <div class="col-md-7">
                                                {{(!is_null($origin))?($origin->race?:"-"):"-"}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Religion</label>
                                            <div class="col-md-7">
                                                {{(!is_null($origin))?($origin->religion?:"-"):"-"}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Denomination</label>
                                            <div class="col-md-7">
                                                {{(!is_null($origin))?($origin->denomination?:"-"):"-"}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="academic_data" role="tabpanel" aria-labelledby="link-tab"
                     aria-expanded="false">

                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Primary Education</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">

                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <?php
                                        $schoolRecords = $user->schoolRecords;
                                        $primary = $schoolRecords->where("school_type", "P");
                                        $primaryCount = $primary->count();

                                        $g7_results = $user->grade7ExamCentres;
                                        ?>

                                        <h4 class="form-section"><i class="la la-institution"></i> Primary School Info
                                        </h4>
                                        @if($primaryCount > 0)
                                            <div class="table-responsive mt-1">
                                                <table class="table">
                                                    <thead class="bg-blue white">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>School</th>
                                                        <th>Town</th>
                                                        <th>From Grade</th>
                                                        <th>To Grade</th>
                                                        <th>From Year</th>
                                                        <th>To Year</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($primary->all() as $item)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$item->name}}</td>
                                                            <td>{{$item->town}}</td>
                                                            <td>{{$item->from_level}}</td>
                                                            <td>{{$item->to_level}}</td>
                                                            <td>{{$item->from_year}}</td>
                                                            <td>{{$item->to_year}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif

                                        <h4 class="form-section mt-2"><i class="la la-institution"></i> Grade 7 Result
                                        </h4>
                                        @php($g7ResultCount = $g7_results->count())

                                        @if($g7ResultCount > 0)
                                            <div class="table-scrollable mt-1" id="alevelCertificatesDiv">
                                                <table
                                                    class="table table-striped table-bordered table-advance table-hover text-center"
                                                    id="alevelCertificatesTable">
                                                    <thead class="bg-blue white">
                                                    <tr>
                                                        <th>Centre</th>
                                                        <th>Results</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($g7_results->all() as $result)
                                                        <tr id="cert-{{$result->id}}">
                                                            <td>
                                                                {{$result->centre}}
                                                            </td>
                                                            <td>
                                                                @foreach($result->results as $cert_result)
                                                                    <span class="subgrade-rez"
                                                                          data-subject="{{$subject = $cert_result->subject}}"
                                                                          data-grade="{{$grade = $cert_result->points}}">
                                                                    {{$subject}} - {{$grade}} point(s)</span><br/>
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Secondary Education</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">

                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <?php
                                        $secondary = $schoolRecords->where("school_type", "S");
                                        $secondaryCount = $secondary->count();
                                        ?>

                                        <h4 class="form-section"><i class="la la-institution"></i> Secondary School Info
                                        </h4>

                                        @if($secondaryCount > 0)
                                            <div class="table-responsive mt-1">
                                                <table class="table">
                                                    <thead class="bg-blue white">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>School</th>
                                                        <th>Town</th>
                                                        <th>From Form</th>
                                                        <th>To Form</th>
                                                        <th>From Year</th>
                                                        <th>To Year</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($secondary->all() as $item)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$item->name}}</td>
                                                            <td>{{$item->town}}</td>
                                                            <td>{{$item->from_level}}</td>
                                                            <td>{{$item->to_level}}</td>
                                                            <td>{{$item->from_year}}</td>
                                                            <td>{{$item->to_year}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif

                                        <h4 class="form-section mt-3">
                                            <i class="la la-certificate"></i> O'level Certificate(s)
                                        </h4>

                                        <?php
                                        $certificates = $user->secondaryExamCertificates;
                                        $olevelCertCount = $certificates->where('level', 'O')->count();
                                        $alevelCertCount = $certificates->where('level', 'A')->count();
                                        ?>

                                        @if($olevelCertCount > 0)
                                            <div class="table-responsive mt-1" id="olevelCertificatesDiv">
                                                <table
                                                    class="table table-striped table-bordered table-advance table-hover text-center"
                                                    id="olevelCertificatesTable">
                                                    <thead class="bg-blue white">
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>Year</th>
                                                        <th>Examining Board</th>
                                                        <th>Center & Candidate #</th>
                                                        <th>Results</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($certificates->where('level','O')->all() as $result)
                                                        <tr id="cert-{{$result->id}}">
                                                            <td class="month"
                                                                data-value="{{ \Carbon\Carbon::createFromFormat('F',$result->result_month)->format('M')}}">
                                                                {{$result->result_month}}
                                                            </td>
                                                            <td class="year" data-value="{{$result->result_year}}">
                                                                {{$result->result_year}}
                                                            </td>
                                                            <td class="examining_body"
                                                                data-value="{{$ex_body = $result->examining_body}}">{{$ex_body}}</td>
                                                            <td class="multiple-details"
                                                                data-center="{{$center = $result->center_number}}"
                                                                data-candidate-no="{{$cand = $result->candidate_number}}"
                                                                data-cert-no="{{$result->certificate_number}}">
                                                                {{$center}} - {{$cand}}
                                                            </td>
                                                            <td>

                                                                @foreach($result->results as $cert_result)
                                                                    <span class="subgrade-rez"
                                                                          data-subject="{{$subject = $cert_result->subject}}"
                                                                          data-grade="{{$grade = $cert_result->grade}}">
                                                    {{$subject}} - {{$grade}}</span><br/>
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif

                                        <h4 class="form-section mt-3">
                                            <i class="la la-certificate"></i> A'level Certificate(s)
                                        </h4>

                                        @if($alevelCertCount > 0)
                                            <div class="table-responsive mt-1" id="alevelCertificatesDiv">
                                                <table
                                                    class="table table-striped table-bordered table-advance table-hover text-center"
                                                    id="alevelCertificatesTable">
                                                    <thead class="bg-blue white">
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>Year</th>
                                                        <th>Examining Board</th>
                                                        <th>Center & Candidate #</th>
                                                        <th>Results</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($certificates->where('level','A')->all() as $result)
                                                        <tr id="cert-{{$result->id}}">
                                                            <td class="month"
                                                                data-value="{{ \Carbon\Carbon::createFromFormat('F',$result->result_month)->format('M')}}">
                                                                {{$result->result_month}}
                                                            </td>
                                                            <td class="year" data-value="{{$result->result_year}}">
                                                                {{$result->result_year}}
                                                            </td>
                                                            <td class="examining_body"
                                                                data-value="{{$ex_body = $result->examining_body}}">{{$ex_body}}</td>
                                                            <td class="multiple-details"
                                                                data-center="{{$center = $result->center_number}}"
                                                                data-candidate-no="{{$cand = $result->candidate_number}}"
                                                                data-cert-no="{{$result->certificate_number}}">
                                                                {{$center}} - {{$cand}}
                                                            </td>
                                                            <td>
                                                                @foreach($result->results as $cert_result)
                                                                    <span class="subgrade-rez"
                                                                          data-subject="{{$subject = $cert_result->subject}}"
                                                                          data-grade="{{$grade = $cert_result->grade}}">
                                                    {{$subject}} - {{$grade}}</span><br/>
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Tertiary Education</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">

                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <?php
                                        $qualifications = $user->tertiaryQualifications;
                                        ?>
                                        @if($qualifications->count()>0)
                                            <div class="table-responsive mt-1">
                                                <table class="table">
                                                    <thead class="bg-blue white">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Institution</th>
                                                        <th>Qualification</th>
                                                        <th>Results</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($qualifications->all() as $item)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$item->institution_name}}</td>
                                                            <td>{{$item->qualification_title}}</td>
                                                            <td>
                                                                @foreach($item->periods as $period)
                                                                    <span class="text-center text-bold-600">
                                                                    {{$period->period}}
                                                                </span><br/>

                                                                    @forelse($period->results as $result)
                                                                        {{$result->module}} - {{$result->grade}}<br/>
                                                                    @empty
                                                                        <span
                                                                            class="text-center">No Results Added</span>
                                                                        <br>
                                                                    @endforelse
                                                                @endforeach
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane" id="sponsor_data" role="tabpanel" aria-labelledby="dropdownOpt1-tab"
                     aria-expanded="false">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Sponsor Details</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">

                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @php($sponsor = $user->sponsorInformation)
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Name</label>
                                            <div class="col-md-7">
                                                {{(!is_null($sponsor))?($sponsor->name?:"-"):"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Cellphone</label>
                                            <div class="col-md-7">
                                                {{(!is_null($sponsor))?($sponsor->cellphone?:"-"):"-"}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">E-mail</label>
                                            <div class="col-md-7">
                                                {{(!is_null($sponsor))?($sponsor->email?:"-"):"-"}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Property Number</label>
                                            <div class="col-md-7">
                                                {{(!is_null($sponsor))?($sponsor->house_number?:"-"):"-"}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Street</label>
                                            <div class="col-md-7">
                                                {{(!is_null($sponsor))?($sponsor->street_name?:"-"):"-"}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Suburb</label>
                                            <div class="col-md-7">
                                                {{(!is_null($sponsor))?($sponsor->suburb?:"-"):"-"}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">City</label>
                                            <div class="col-md-7">
                                                {{(!is_null($sponsor))?($sponsor->city?:"-"):"-"}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Suburb</label>
                                            <div class="col-md-7">
                                                {{(!is_null($sponsor))?($sponsor->country?:"-"):"-"}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="current_data" role="tabpanel" aria-labelledby="dropdownOpt2-tab"
                     aria-expanded="false">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Transactions</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">

                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <div class="table-responsive mt-1">
                                            <table class="table table-striped table-bordered">
                                                <thead class="bg-blue white">
                                                <tr>
                                                    <th>Ref</th>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>DR</th>
                                                    <th>CR</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($transactions as $transaction)
                                                    <tr>
                                                        <td>{{ $transaction->ref }}</td>
                                                        <td>{{ $transaction->transactiondate }}</td>
                                                        <td>{{ $transaction->description }}</td>
                                                        <td>{{ ($transaction->debit != 0)?"$".$transaction->debit:"" }}</td>
                                                        <td>{{ ($transaction->credit != 0)?"$".$transaction->credit:"" }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-capitalize">No Financial
                                                            Record
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                <div class="tab-pane" id="linkOpt" role="tabpanel" aria-labelledby="linkOpt-tab"--}}
                {{--                     aria-expanded="false">--}}

                {{--                </div>--}}
                <div class="tab-pane" id="manage_account" role="tabpanel" aria-labelledby="linkOpt-tab"
                     aria-expanded="false">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Account Email</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">

                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <form action="{{route("staff.students.update-email",["user"=>$user->id])}}"
                                          method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form row">
                                                <div class="form-group mb-1 col-sm-12 col-md-4">
                                                    <label for="update-email">Email address</label>
                                                    <br>
                                                    {!! Form::email("email",((!is_null($contact))?$contact->email:null),
                                                    ["id"=>"update-email","placeholder"=>"E-mail","class"=>"form-control","disabled"=>true]) !!}
                                                </div>
                                                <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                                    <button id="updateEmailBtn" type="button" class="btn btn-warning"><i
                                                            class="ft-edit-3"></i> Edit E-mail Address
                                                    </button>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                                    <button type="submit" class="btn btn-success"><i
                                                            class="ft-save"></i> Update E-mail
                                                    </button>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                                    <a href="{{route("staff.students.send-reset",["user"=>$user->id])}}"
                                                       class="btn btn-info"><i class="ft-mail"></i> Reset Password
                                                    </a>
                                                </div>

                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Pastel Account Link</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">

                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <form action="{{route("staff.students.update-pastel",["user"=> $user->id])}}"
                                          method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form row">
                                                <div class="form-group mb-1 col-sm-12 col-md-4">
                                                    <label for="pastel">Pastel Account Details</label>
                                                    @php($pastel_account = App\PastelAccountName::find($user->national_id))
                                                    <br/>
                                                    {!! Form::text("pastel",
                                                    (is_null($pastel_account)?null:$pastel_account->Account),
                                                    ["id"=>"update-pastel","placeholder"=>"Pastel Account","class"=>"form-control","disabled"=>true]) !!}
                                                    <br/>
                                                    <div class="custom-control custom-checkbox ml-1">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="moveTransactions" id="moveTransactions"
                                                               value="yes" disabled>
                                                        <label class="custom-control-label" for="moveTransactions">Move
                                                            Transactions from the current account to the new
                                                            account. <strong class="text-danger">Be careful not to merge
                                                                transactions between two different
                                                                accounts.</strong></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                                    <button id="updatePastelBtn" type="button" class="btn btn-warning">
                                                        <i class="ft-edit-3"></i> Edit Pastel Account
                                                    </button>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                                    <button type="submit" class="btn btn-info"><i
                                                            class="ft-save"></i> Update Pastel Link
                                                    </button>
                                                </div>

                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push("pageJavascript")
    <script>
        let $state = true;
        let $clickCount = 0;
        let $txtEmailContent = "";
        $("#updateEmailBtn").click(function () {
            $state = !$state;

            $("#update-email").prop("disabled", $state);

            if ($clickCount < 5) {
                $clickCount++;
            }

            if ($clickCount == 1) {
                $txtEmailContent = $("#update-email").val();
            }

            if ($state) {
                $("#update-email").val($txtEmailContent);
            }
        });
        let $state1 = true;
        let $clickCount1 = 0;
        let $txtPastelContent = "";
        $("#updatePastelBtn").click(function () {
            $state1 = !$state1;

            $("#update-pastel, #moveTransactions").prop("disabled", $state1);

            if ($clickCount1 < 5) {
                $clickCount1++;
            }

            if ($clickCount1 == 1) {
                $txtPastelContent = $("#update-pastel").val();
            }

            if ($state1) {
                $("#update-pastel").val($txtPastelContent);
            }
        });
    </script>
@endpush


