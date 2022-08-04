@extends('layouts.master')

@section('pageTitle',"Stage 1: Personal Information")

@section('mainCon')
    @include('layouts.partials.stage-viewer')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="bordered-layout-basic-form">Update Personal Information</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                {{--<li><a data-action="collapse"><i class="ft-minus"></i></a></li>--}}
                                {{--<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>--}}
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                {{--<li><a data-action="close"><i class="ft-x"></i></a></li>--}}
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="card-text">
                                <p>Please provide your personal information.</p>
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
                            <form class="form form-horizontal form-bordered" method="post"
                                  action="{{route('urp.stage1')}}">
                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-user"></i> Personal Info</h4>
                                    <?php
                                    $user = auth()->user();
                                    $dob = ["day" => null, "month" => null, "year" => null];

                                    if (($user->student_type == "new")) {
                                        $personalInformation = $user->personalInformation;
                                        $expDob = explode("-", $personalInformation->date_of_birth);
                                        if (count($expDob) == 3) {
                                            $dob["day"] = $expDob[2];
                                            $dob["month"] = $expDob[1];
                                            $dob["year"] = $expDob[0];
                                        }
                                    }
                                    ?>
                                    <div class="form-group row {{ $errors->has('title') ? ' issue' : '' }}">
                                        <label class="col-md-3 label-control" for="titleSt">Title</label>
                                        <div class="col-md-9">
                                        {!! Form::select('title',
                                        ["Mr"=>"Mr","Mrs"=>"Mrs","Miss"=>"Miss","Dr"=>"Dr","Ms"=>"Ms","Rev"=>"Rev","Sr"=>"Sr","Prof"=>"Prof"],
                                        ($user->student_type == "new")?ucfirst(strtolower($personalInformation->title)):null,
                                        ["class"=>"form-control", "id"=>"titleSt"]+(($user->student_type == "new")?["readonly"=>true]:[])) !!}
                                        {!! $errors->first('title','<span class="font-red-mint validation-error">:message</span>')!!}
                                        <!--<div class="form-control-focus"></div>-->
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="fname">First Name(s)</label>
                                        <div class="col-md-9">
                                            <input type="text" id="fname" class="form-control"
                                                   placeholder="First Name(s)"
                                                   name="first_name"
                                                   {{ ((auth()->user()->student_type == "new")?"readonly=\"readonly\"":"") }}
                                                   value="{{ old("first_name")?:((auth()->user()->student_type == "new")?$user->first_name:"") }}">
                                            <p class="text-left mb-0">
                                                <small class="text-muted">Provide your first name(s) as they appear on
                                                    your birth certificate. If you have more than 1 name, they should be
                                                    provided in full.
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="surname">Surname</label>
                                        <div class="col-md-9">
                                            <input type="text" id="surname" class="form-control"
                                                   placeholder="Surname"
                                                   name="surname"
                                                   {{ ((auth()->user()->student_type == "new")?"readonly=\"readonly\"":"") }}
                                                   value="{{ old("surname")?:((auth()->user()->student_type == "new")?$user->last_name:"") }}">
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('gender') ? ' issue' : '' }}">
                                        <label class="col-md-3 label-control">Gender</label>
                                        <div class="col-md-9">
                                            {!! Form::select('gender',["MALE"=>"Male","FEMALE"=>"Female"],
                                            ($user->student_type == "new")?$user->personalInformation->gender:null,
                                            ["class"=>"form-control", "id"=>"genderSt"]+((auth()->user()->student_type == "new")?["readonly"=>true]:[])) !!}
                                            {!! $errors->first('gender','<span class="font-red-mint validation-error">:message</span>')!!}
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('date_of_birth') ? ' issue' : '' }}">
                                        <label class="col-md-3 label-control" for="date_of_birth">Date of Birth</label>
                                        <div class="col-md-9">
                                            <div class="row">

                                                @php
                                                    function pad($input)
                                                    {
                                                        return sprintf("%02d", $input);
                                                    }
                                                @endphp

                                                <div class="col-md-3">
                                                    {!! Form::select('birth_day',
                                                    ([""=>"Day"]+array_combine(array_map('pad', range(1,31)),range(1,31)))
                                                    ,$dob["day"],['id'=>'birth_day',"class"=>"form-control"]) !!}
                                                </div>

                                                <div class="col-md-5">
                                                    {!! Form::select('birth_month',
                                                    ([""=>"Month"]+array_reduce(array_map('pad', range(1,12)),function($rslt,$m){ $rslt[$m] = date('F',mktime(0,0,0,$m,10)); return $rslt; })),
                                                    $dob["month"],['id'=>'birth_month',"class"=>"form-control"]) !!}
                                                </div>
                                                <div class="col-md-4">
                                                    {!! Form::select('birth_year',
                                                    ([""=>"Year"]+array_combine(range((date('Y')-10),(date('Y')-110)),range((date('Y')-10),(date('Y')-110)))),
                                                    $dob["year"],['id'=>'birth_year',"class"=>"form-control"]) !!}
                                                </div>
                                            </div>
                                            {!! $errors->first('date_of_birth','<span class="font-red-mint validation-error">:message</span><br/>')!!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="passport">Passport</label>
                                        <div class="col-md-9">
                                            <input type="text" id="passport" class="form-control"
                                                   placeholder="Passport" name="passport" value="{{ old("passport") }}">
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('marital_status') ? ' has-error' : '' }}">
                                        <label class="col-md-3 label-control">Marital Status</label>
                                        <div class="col-md-9">
                                            {!! Form::select('marital_status',[
                                            "Single"=>"Single",
                                            "Married"=>"Married",
                                            "Divorced"=>"Divorced",
                                            "Widowed"=>"Widowed",
                                            ],null,["class"=>"form-control", "id"=>"marital_status"]) !!}
                                            {!! $errors->first('marital_status','<span class="font-red-mint validation-error">:message</span>')!!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="approx_height">Approx. Height</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input name="height" type="number" class="form-control" min="80"
                                                       max="300" placeholder="Approximate Height"
                                                       aria-describedby="basic-addon2"
                                                       value="{{Session::hasOldInput("height")?Session::getOldInput("height"):''}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">cm</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row last">
                                        <label class="col-md-3 label-control" for="approx_mass">Approx. Mass</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input name="mass" type="number" class="form-control" min="20" max="300"
                                                       placeholder="Approximate Mass" aria-describedby="basic-addon2"
                                                       value="{{Session::hasOldInput("mass")?Session::getOldInput("mass"):''}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">kg</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions right">
                                    <a href="{{route('assistance')}}"> Facing Challenges, with adding records? Click
                                        Here</a>
                                    <button type="button" class="btn btn-warning mr-1">
                                        <i class="ft-x"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascripts')
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

            @if(Session::hasOldInput("birth_day"))
            $('[name="birth_day"] option[value="{{Session::getOldInput("birth_day")}}"], ' +
                '[name="birth_month"] option[value="{{Session::getOldInput("birth_month")}}"],' +
                '[name="birth_year"] option[value="{{Session::getOldInput("birth_year")}}"]').prop('selected', 'selected');
            @else
            @if(($user->student_type == "new"))
            $('[name="birth_day"] option[value="{{$dob["day"]}}"], ' +
                '[name="birth_month"] option[value="{{$dob["month"]}}"],' +
                '[name="birth_year"] option[value="{{$dob["year"]}}"]').prop('selected', 'selected');
            @endif
            @endif

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

        });


    </script>
@endpush
