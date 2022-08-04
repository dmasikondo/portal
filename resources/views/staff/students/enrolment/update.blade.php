@extends("layouts.staff-master")

@section("pageTitle","Update Student Enrolment")

@section("headerTitle","Update Student Enrolment")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">
                            <a href="{{route("staff.students.enrolment")}}" class="btn btn-icon btn-light mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            Update Student Enrolment</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                        </div>
                    </div>
                </div>
                <div class="card-content" id="programmeThing">

                    <div class="card-body">
                        <!-- Create New User -->
                        <div class="card-text">
                            <p>Please provide student details.</p>
                        </div>
                        @if(count($errors->all()) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert round bg-danger alert-icon-left alert-dismissible mb-2"
                                     role="alert">
                                    <span class="alert-icon"><i class="la la-exclamation-triangle"></i></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {{$error}}
                                </div>
                            @endforeach
                        @endif

                        {!! Form::model($base_enrolled_student,['route'=>['staff.students.enrolment.update',$base_enrolled_student->id],
                        "method"=>"PATCH","class"=>"form form-horizontal form-bordered"]) !!}

                        <div class="form-body">

                            <div class="form-group row {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label class="col-md-3 label-control" for="title">Title</label>
                                <div class="col-md-9">
                                    {!! Form::select('title',["Mr"=>"Mr","Mrs"=>"Mrs","Miss"=>"Miss","Dr"=>"Dr","Ms"=>"Ms","Rev"=>"Rev","Sr"=>"Sr","Prof"=>"Prof"],null,["class"=>"form-control", "id"=>"titleSt"]) !!}
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label class="col-md-3 label-control" for="form_control_1">First Name</label>
                                <div class="col-md-9">
                                    {!! Form::text("first_name",null,["id"=>"first_name","placeholder"=>"First Name","class"=>"form-control"]) !!}
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('surname') ? ' has-error' : '' }}">
                                <label class="col-md-3 label-control" for="surname">Surname</label>
                                <div class="col-md-9">
                                    {!! Form::text("surname",
                                    ((isset($base_enrolled_student))?$base_enrolled_student->last_name:null)
                                    ,["id"=>"surname","placeholder"=>"Last Name","class"=>"form-control"]) !!}
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('maiden_name') ? ' has-error' : '' }}">
                                <label class="col-md-3 label-control" for="maiden_name">Maiden Name</label>
                                <div class="col-md-9">
                                    {!! Form::text("maiden_name",null,["id"=>"maiden_name","placeholder"=>"Maiden Name","class"=>"form-control"]) !!}
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('gender') ? ' has-error' : '' }}">
                                <label class="col-md-3 label-control" for="gender">Gender</label>
                                <div class="col-md-9">
                                    {!! Form::select('gender',["Male"=>"Male","Female"=>"Female"],null,["class"=>"form-control", "id"=>"genderSt"]) !!}
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('type_of_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 label-control" for="type_of_id">Type Of ID</label>
                                <div class="col-md-9">
                                    {!! Form::select('type_of_id',["zim_id"=>"Zimbabwean National ID","foreign_id"=>"Foreign Passport/ID"],
                                    (!preg_match("/^(([0-9]{2})([\-])([0-9]{6,})([A-Z]{1})([0-9]{2}))$/",$base_enrolled_student->national_id))?'foreign_id':'zim_id'
                                    ,["class"=>"form-control", "id"=>"type_of_id"]) !!}
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('national_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 label-control" for="national_id">National ID</label>
                                <div class="col-md-9">
                                    {!! Form::text("national_id",null,["id"=>"national_id","class"=>"form-control"]) !!}
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('date_of_birth') ? ' issue' : '' }}">
                                <label class="col-md-3 label-control" for="date_of_birth">Date of Birth</label>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-3">
                                            {!! Form::select('birth_day',[],null,['id'=>'birth_day',"class"=>"form-control"]) !!}
                                        </div>

                                        <div class="col-md-5">
                                            {!! Form::select('birth_month',[],null,['id'=>'birth_month',"class"=>"form-control"]) !!}
                                        </div>
                                        <div class="col-md-4">
                                            {!! Form::select('birth_year',[],null,['id'=>'birth_year',"class"=>"form-control"]) !!}
                                        </div>
                                    </div>
                                    {!! $errors->first('date_of_birth','<span class="font-red-mint validation-error">:message</span><br/>')!!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="form_control_1">Department</label>
                                <div class="col-md-9">
                                {!! Form::select('department', $departments,
                                ((isset($enrolled_programme) && !is_null($enrolled_programme))?$enrolled_programme->departmentid:null),
                                 ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                <!--<div class="form-control-focus"></div>-->
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="form_control_1">Qualification</label>
                                <div class="col-md-9">
                                    {!! Form::select('qualification',
                                    ((isset($enrolled_programme) && !is_null($enrolled_programme))?
                                    collect((new \App\Department)->getQualificationsByDepartment($enrolled_programme->departmentid))->pluck('name',"id"):[]),
                                    $base_enrolled_student->qualificationid,
                                    ["class"=>"form-control", "id"=>"form_control_1"]) !!}
{{--                                    </select>--}}
                                    <!--<div class="form-control-focus"></div>-->
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="form_control_1">Course</label>
                                <div class="col-md-9">
                                {!! Form::select('course',
                                collect((new \App\Programme)->getProgrammeByQualificationDepartment($enrolled_programme->departmentid, $base_enrolled_student->qualificationid))->pluck('name','id'),
                                ((isset($enrolled_programme) && !is_null($enrolled_programme))?$enrolled_programme->id:null)
                                ,["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                <!--<div class="form-control-focus"></div>-->
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('mode_of_entry') ? ' has-error' : '' }}">
                                <label class="col-md-3 label-control" for="mode_of_entry">Mode Of Entry</label>
                                <div class="col-md-9">
                                    {!! Form::select('mode_of_entry',[
                                    "full_time"=>"Full Time","part_time"=>"Part Time","ojet"=>"OJET",
                                    "apprenticeship_res" => "Apprenticeship (Res)",
                                    "apprenticeship_non_res"=>"Apprenticeship (Non-Res)"],null,["class"=>"form-control", "id"=>"mode_of_entry"]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="phone_number">Phone Number</label>
                                <div class="col-md-9">
                                    {!! Form::text("phone_number",null,["id"=>"phone_number","placeholder"=>"Phone Number","class"=>"form-control"]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="house_number">House No</label>
                                <div class="col-md-9">
                                    {!! Form::text("house_number",null,["id"=>"house_number","placeholder"=>"House Number","class"=>"form-control"]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="street_name">Street</label>
                                <div class="col-md-9">
                                    {!! Form::text("street_name",null,["id"=>"street_name","placeholder"=>"Street Name","class"=>"form-control"]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="suburb">Suburb/Village</label>
                                <div class="col-md-9">
                                    {!! Form::text("suburb",null,["id"=>"suburb","placeholder"=>"Suburb/Village","class"=>"form-control"]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="city">City/Town/Growth Point</label>
                                <div class="col-md-9">
                                    {!! Form::text("city",null,["id"=>"city","placeholder"=>"City/Town/Growth Point","class"=>"form-control"]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="district">District</label>
                                <div class="col-md-9">
                                    {!! Form::text("district",null,["id"=>"district","placeholder"=>"District","class"=>"form-control"]) !!}
                                </div>
                            </div>

                            <div class="form-group row last {{ $errors->has('country') ? ' has-error' : '' }}">
                                <label class="col-md-3 label-control" for="form_control_1">Country</label>
                                <div class="col-md-9">
                                {!! Form::select('country',DB::table('countries')->pluck('name','code'),
                                    null, ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                <!--<div class="form-control-focus"></div>-->
                                    {!! $errors->first('country','<span class="font-red-mint validation-error">:message</span>')!!}
                                </div>
                            </div>

                        </div>
                        <div class="form-actions right">
                            <a href="{{route("staff.students.enrolment-view")}}" class="btn btn-warning mr-1">
                                <i class="ft-x"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="la la-check-square-o"></i> Update
                            </button>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageJavascript')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
    {!! Html::script('app-assets/js/scripts/dobPicker.min.js') !!}
    <script>
        $(document).ready(function () {
            $("select[name='birth_day'], select[name='birth_month'], select[name='birth_year']").empty();
            $.dobPicker({
                daySelector: '#birth_day',
                monthSelector: '#birth_month',
                yearSelector: '#birth_year',
                dayDefault: 'Day',
                monthDefault: 'Month',
                yearDefault: 'Year',
                minimumAge: 10,
                maximumAge: 110
            });

            @php($exp_date = explode("-",$base_enrolled_student->date_of_birth))
            $('[name="birth_day"] option[value="{{old("birth_day")?:$exp_date[2]}}"], ' +
                '[name="birth_month"] option[value="{{old("birth_month")?:$exp_date[1]}}"],' +
                '[name="birth_year"] option[value="{{old("birth_year")?:$exp_date[0]}}"]').prop('selected', 'selected');


            // getQualifications('select[name="department"]');
            let $department_id;
            $('select[name="department"]').on("change", function (e) {
                getQualifications(this);
            });

            $('select[name="qualification"]').on("change", function (e) {
                // let $qualification = $('select[name="qualification"]');
                let $course = $('select[name="course"]');
                $course.prop("disabled", true);
                $course.empty().append('<option value="">Select Your Course</option>');
                $department_id = parseInt($('select[name="department"]').val());// + 1;

                if (isNaN($department_id))
                    return;
                $("#programmeThing").block({
                    message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
                    // timeout: 2000, //unblock after 2 seconds
                    overlayCSS: {
                        backgroundColor: '#fff',
                        opacity: 0.8,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        padding: 0,
                        backgroundColor: 'transparent'
                    }
                });

                $.get("{{route('json.programmeList')}}?department=" + $department_id + "&qualification=" + $(this).val(), function (data) {
                    if (data.length > 0) {
                        console.log(data);
                        data.forEach(function (item, index) {
                            $course.append('<option value="' + item.id + '">' + item.name + '</option>');
                        })
                        $course.prop("disabled", false);
                    }
                });

                $("#programmeThing").unblock();

            });

            $('#genderSt').on('change', function () {
                let $genderSt = $(this);

                if ($genderSt.val() == "Female") {
                    $("#titleSt option[value='Miss']").prop("selected", true);
                } else if ($genderSt.val() == "Male") {
                    $("#titleSt option[value='Mr']").prop("selected", true);
                }
            });

            $('#titleSt').on('change', function () {
                let $genderSt = $("#genderSt");
                let $males = $("#genderSt option[value='Male']");
                let $females = $("#genderSt option[value='Female']");

                $males.prop("disabled", false);
                $females.prop("disabled", false);


                let $married_status = $("#marital_status option[value='Married']");
                let $single_status = $("#marital_status option[value='Single']");
                // $married_status.prop("checked", false);
                $married_status.prop("disabled", false);
                $males.prop("Male");
                let $title = this.value;
                let male_titles = ["Mr"];
                let non_married_females = ["Miss", "Ms"];
                let married_female = ["Mrs"];
                let female_titles = married_female.concat(non_married_females);

                if ($.inArray($title, male_titles) !== -1) {
                    $females.prop("disabled", true);
                    $males.prop("selected", true);
                }

                if ($.inArray($title, female_titles) !== -1) {
                    $females.prop("selected", true);
                    $males.prop("disabled", true);
                    if ($.inArray($title, non_married_females) !== -1) {
                        $single_status.prop("selected", true);
                        $married_status.prop("disabled", true);
                    }
                    if ($.inArray($title, married_female) !== -1) {
                        $married_status.prop("selected", true);
                    }
                }
            });

            function getQualifications(elem) {
                let $qualification = $('select[name="qualification"]');
                let $course = $('select[name="course"]');
                $qualification.prop("disabled", true);
                $course.prop("disabled", true);
                $qualification.empty().append('<option value="">Select Your Qualification</option>');
                $course.empty().append('<option value=""></option>');
                $department_id = parseInt($(elem).val());// + 1;

                if (!isNaN($department_id)) {
                    $("#programmeThing").block({
                        message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
                        // timeout: 2000, //unblock after 2 seconds
                        overlayCSS: {
                            backgroundColor: '#fff',
                            opacity: 0.8,
                            cursor: 'wait'
                        },
                        css: {
                            border: 0,
                            padding: 0,
                            backgroundColor: 'transparent'
                        }
                    });

                    $.get("{{route('json.qualificationList')}}?department=" + $department_id, function (data) {
                        if (data.length > 0) {
                            data.forEach(function (item, index) {
                                $qualification.append('<option value="' + item.id + '">' + item.name + '</option>');
                            })
                            $qualification.prop("disabled", false);
                        }
                    });
                    $("#programmeThing").unblock();
                }
            }
        });
    </script>
@endpush


