@extends('layouts.master')

@section('pageTitle',"Stage 3: Contact Information")

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
                                    {{--                                    @php($contacts = \Auth::user()->contactInformation)--}}
                                    <h4 class="form-section"><i class="la la-map-marker"></i> Contact Info</h4>
                                    @if(is_null(\Auth::user()->contactInformation))
                                        {{--                                    @if(is_null($contacts) ||(!is_null($contacts) && ( empty($contacts->) || )))--}}
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="cellphone">Cellphone
                                                Number</label>
                                            <div class="col-md-9">
                                                <input type="text" id="cellphone" class="form-control"
                                                       placeholder="Your Cellphone Number"
                                                       name="cellphone"
                                                       value="{{Session::hasOldInput("cellphone")?Session::getOldInput("cellphone"):""}}">
                                                <p class="text-left mb-0">
                                                    <small class="text-muted">This cellphone number must be accessible
                                                        to
                                                        you at anytime and able to receive text messages. Format:
                                                        +263773123456
                                                    </small>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="email">E-mail</label>
                                            <div class="col-md-9">
                                                <input type="text" id="email" class="form-control"
                                                       placeholder="Your E-mail"
                                                       name="email"
                                                       value="{{Session::hasOldInput("email")?Session::getOldInput("email"):""}}">
                                                <p class="text-left mb-0">
                                                    <small class="text-muted">This e-mail number must be accessible to
                                                        you
                                                        at anytime. Format: email@exmple.com
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="house_number">Your House No</label>
                                        <div class="col-md-9">
                                            <input type="text" id="house_number" class="form-control"
                                                   placeholder="Your House Number"
                                                   name="house_number"
                                                   value="{{Session::hasOldInput("house_number")?Session::getOldInput("house_number"):""}}">
                                            <p class="text-left mb-0">
                                                <small class="text-muted">The number given to your house alone in your
                                                    area. Ex. 4072
                                                </small>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="street_name">Street</label>
                                        <div class="col-md-9">
                                            <input type="text" id="street_name" class="form-control"
                                                   placeholder="Your Street Name"
                                                   name="street_name"
                                                   value="{{Session::hasOldInput("street_name")?Session::getOldInput("street_name"):""}}">
                                            <p class="text-left mb-0">
                                                <small class="text-muted">The name of the street in which your house is
                                                    found. Ex. 5th Street
                                                </small>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="suburb">Suburb</label>
                                        <div class="col-md-9">
                                            <input type="text" id="suburb" class="form-control"
                                                   placeholder="Your Suburb"
                                                   name="suburb"
                                                   value="{{Session::hasOldInput("suburb")?Session::getOldInput("suburb"):""}}">
                                            <p class="text-left mb-0">
                                                <small class="text-muted">The area within a city/town in which your
                                                    house is located. Ex. Mbare
                                                </small>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="city">City/Town/Growth Point</label>
                                        <div class="col-md-9">
                                            <input type="text" id="city" class="form-control"
                                                   placeholder="Your City/Town/Growth Point"
                                                   name="city"
                                                   value="{{Session::hasOldInput("city")?Session::getOldInput("city"):""}}">
                                            <p class="text-left mb-0">
                                                <small class="text-muted">The name of the city/town in which your house
                                                    is located. Ex. Harare
                                                </small>
                                            </p>

                                        </div>
                                    </div>

                                    <div class="form-group row last {{ $errors->has('country') ? ' has-error' : '' }}">
                                        <label class="col-md-3 label-control" for="form_control_1">Country</label>
                                        <div class="col-md-9">
                                        {!! Form::select('country',DB::table('countries')->pluck('name','code'),
                                            "ZW", ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                        <!--<div class="form-control-focus"></div>-->
                                            {!! $errors->first('country','<span class="font-red-mint validation-error">:message</span>')!!}
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions right">
                                    <a href="{{route('assistance')}}"> Having Challenges? Click Here</a>
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
