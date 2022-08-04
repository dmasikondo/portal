@extends('layouts.master')

@section('pageTitle',"Stage 3: Next Of Kin Information")

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
                                <p>Please provide your contact details and also note that you will need to verify your
                                    cellphone and e-mail in a later stage so these should be accessible to you.</p>
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
                                  action="{{route('urp.stage3')}}">
                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-user"></i> Next Of Kin Info</h4>

                                    <div class="card-text">
                                        <p>The next of kin is the person closest to you, who would be contacted in case
                                            of any emergency. Please provide the contact details for your next of
                                            kin</p>
                                    </div>

                                    <div class="form-group row {{ $errors->has('next_of_kin_title') ? ' issue' : '' }}">
                                        <label class="col-md-3 label-control" for="titleSt">Title</label>
                                        <div class="col-md-9">
                                        {!! Form::select('next_of_kin_title',["Mr"=>"Mr","Mrs"=>"Mrs","Miss"=>"Miss","Dr"=>"Dr","Ms"=>"Ms","Rev"=>"Rev","Sr"=>"Sr","Prof"=>"Prof"],null,["class"=>"form-control", "id"=>"titleSt"]) !!}
                                        {!! $errors->first('next_of_kin_title','<span class="font-red-mint validation-error">:message</span>')!!}
                                        <!--<div class="form-control-focus"></div>-->
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="next_of_kin_first_names">First
                                            Name(s)</label>
                                        <div class="col-md-9">
                                            <input type="text" id="next_of_kin_first_names" class="form-control"
                                                   placeholder="Next Of Kin First Names"
                                                   name="next_of_kin_first_names"
                                                   value="{{Session::hasOldInput("next_of_kin_first_names")?Session::getOldInput("next_of_kin_first_names"):""}}">

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="next_of_kin_surname">Surname</label>
                                        <div class="col-md-9">
                                            <input type="text" id="next_of_kin_surname" class="form-control"
                                                   placeholder="Next Of Kin Surname"
                                                   name="next_of_kin_surname"
                                                   value="{{Session::hasOldInput("next_of_kin_surname")?Session::getOldInput("next_of_kin_surname"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('next_of_kin_date_of_birth') ? ' issue' : '' }}">
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
                                                    ,null,['id'=>'birth_day',"class"=>"form-control"]) !!}
                                                </div>

                                                <div class="col-md-5">
                                                    {!! Form::select('birth_month',
                                                    ([""=>"Month"]+array_reduce(array_map('pad', range(1,12)),function($rslt,$m){ $rslt[$m] = date('F',mktime(0,0,0,$m,10)); return $rslt; })),null,['id'=>'birth_month',"class"=>"form-control"]) !!}
                                                </div>
                                                <div class="col-md-4">
                                                    {!! Form::select('birth_year',
                                                    ([""=>"Year"]+array_combine(range((date('Y')-10),(date('Y')-110)),range((date('Y')-10),(date('Y')-110)))),null,['id'=>'birth_year',"class"=>"form-control"]) !!}
                                                </div>
                                            </div>
                                            {!! $errors->first('next_of_kin_date_of_birth','<span class="font-red-mint validation-error">:message</span><br/>')!!}
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="next_of_kin_national_id">National
                                            ID</label>
                                        <div class="col-md-9">
                                            <input type="text" id="next_of_kin_national_id" class="form-control"
                                                   placeholder="Next Of Kin National ID"
                                                   name="next_of_kin_national_id"
                                                   value="{{Session::hasOldInput("next_of_kin_national_id")?Session::getOldInput("next_of_kin_national_id"):""}}">
                                            <p class="text-left mb-0">
                                                <small class="text-muted">Format: 99-999999X99
                                                </small>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('next_of_kin_gender') ? ' issue' : '' }}">
                                        <label class="col-md-3 label-control" for="next_of_kin_gender">Gender</label>
                                        <div class="col-md-9">
                                            {!! Form::select('next_of_kin_gender',["Male"=>"Male","Female"=>"Female"],null,["class"=>"form-control", "id"=>"genderSt"]) !!}
                                            {!! $errors->first('next_of_kin_gender','<span class="font-red-mint validation-error">:message</span>')!!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="next_of_kin_relationship">Relationship</label>
                                        <div class="col-md-9">
                                            {!! Form::select('next_of_kin_relationship',DB::table('next_of_kin_relationships')->pluck('title','id'),
                                            null, ["class"=>"form-control", "id"=>"next_of_kin_relationship"]) !!}
                                            <p class="text-left mb-0">
                                                <small class="text-muted">Who is the next of kin to you?
                                                </small>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="next_of_kin_cellphone">Cellphone
                                            Number</label>
                                        <div class="col-md-9">
                                            <input type="text" id=next_of_kin_"cellphone" class="form-control"
                                                   placeholder="Next Of Kin Cellphone Number"
                                                   name="next_of_kin_cellphone"
                                                   value="{{Session::hasOldInput("next_of_kin_cellphone")?Session::getOldInput("next_of_kin_cellphone"):""}}">
                                            <p class="text-left mb-0">
                                                <small class="text-muted">Format: +263773123456
                                                </small>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="next_of_kin_email">E-mail</label>
                                        <div class="col-md-9">
                                            <input type="text" id="next_of_kin_email" class="form-control"
                                                   placeholder="Next Of Kin E-mail"
                                                   name="next_of_kin_email"
                                                   value="{{Session::hasOldInput("next_of_kin_email")?Session::getOldInput("next_of_kin_email"):""}}">
                                            <p class="text-left mb-0">
                                                <small class="text-muted">Format: email@example.com</small>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="next_of_kin_house_number">House
                                            No</label>
                                        <div class="col-md-9">
                                            <input type="text" id="next_of_kin_house_number" class="form-control"
                                                   placeholder="Next Of Kin House Number"
                                                   name="next_of_kin_house_number"
                                                   value="{{Session::hasOldInput("next_of_kin_house_number")?
                                                   Session::getOldInput("next_of_kin_house_number"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control"
                                               for="next_of_kin_street_name">Street</label>
                                        <div class="col-md-9">
                                            <input type="text" id="next_of_kin_street_name" class="form-control"
                                                   placeholder="Next Of Kin Street Name"
                                                   name="next_of_kin_street_name"
                                                   value="{{Session::hasOldInput("next_of_kin_street_name")?
                                                   Session::getOldInput("next_of_kin_street_name"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="next_of_kin_suburb">Suburb</label>
                                        <div class="col-md-9">
                                            <input type="text" id="next_of_kin_suburb" class="form-control"
                                                   placeholder="Next Of Kin Suburb"
                                                   name="next_of_kin_suburb"
                                                   value="{{Session::hasOldInput("next_of_kin_suburb")?
                                                   Session::getOldInput("next_of_kin_suburb"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="next_of_kin_city">City/Town/Growth
                                            Point</label>
                                        <div class="col-md-9">
                                            <input type="text" id="next_of_kin_city" class="form-control"
                                                   placeholder="Next Of Kin City/Town/Growth Point"
                                                   name="next_of_kin_city"
                                                   value="{{Session::hasOldInput("next_of_kin_city")?Session::getOldInput("next_of_kin_city"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row last {{ $errors->has('next_of_kin_country') ? ' has-error' : '' }}">
                                        <label class="col-md-3 label-control" for="form_control_1">Country</label>
                                        <div class="col-md-9">
                                        {!! Form::select('next_of_kin_country',DB::table('countries')->pluck('name','code'),
                                            "ZW", ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                        <!--<div class="form-control-focus"></div>-->
                                            {!! $errors->first('next_of_kin_country','<span class="font-red-mint validation-error">:message</span>')!!}
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions right">
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
        $("select[name='birth_day'], select[name='birth_month'], select[name='birth_year']").empty();
        $(document).ready(function () {
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
