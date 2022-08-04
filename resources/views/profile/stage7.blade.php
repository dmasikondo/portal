@extends('layouts.master')

@section('pageTitle',"Stage 8: Sponsor Information")

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
                                <p>Please provide your Sponsor details.</p>
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
                                  action="{{route('urp.stage5')}}">
                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-map-marker"></i> Sponsor Info</h4>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="name">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" id="name" class="form-control"
                                                   placeholder="Sponsor Name"
                                                   name="name"
                                                   value="{{Session::hasOldInput("name")?Session::getOldInput("name"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="cellphone">Cellphone Number</label>
                                        <div class="col-md-9">
                                            <input type="text" id="cellphone" class="form-control"
                                                   placeholder="Sponsor Cellphone Number"
                                                   name="cellphone"
                                                   value="{{Session::hasOldInput("cellphone")?Session::getOldInput("cellphone"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="email">E-mail</label>
                                        <div class="col-md-9">
                                            <input type="text" id="email" class="form-control"
                                                   placeholder="Sponsor E-mail"
                                                   name="email"
                                                   value="{{Session::hasOldInput("email")?Session::getOldInput("email"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="house_number">Property No</label>
                                        <div class="col-md-9">
                                            <input type="text" id="house_number" class="form-control"
                                                   placeholder="Sponsor Property Number"
                                                   name="house_number"
                                                   value="{{old("house_number")}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="street_name">Street</label>
                                        <div class="col-md-9">
                                            <input type="text" id="street_name" class="form-control"
                                                   placeholder="Sponsor Street Name"
                                                   name="street_name"
                                                   value="{{Session::hasOldInput("street_name")?Session::getOldInput("street_name"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="suburb">Suburb</label>
                                        <div class="col-md-9">
                                            <input type="text" id="suburb" class="form-control"
                                                   placeholder="Sponsor Suburb"
                                                   name="suburb"
                                                   value="{{Session::hasOldInput("suburb")?Session::getOldInput("suburb"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="city">City/Town/Growth Point</label>
                                        <div class="col-md-9">
                                            <input type="text" id="city" class="form-control"
                                                   placeholder="Sponsor City/Town/Growth Point"
                                                   name="city"
                                                   value="{{Session::hasOldInput("city")?Session::getOldInput("city"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row last {{ $errors->has('country') ? ' has-error' : '' }}">
                                        <label class="col-md-3 label-control" for="form_control_1">Sponsor
                                            Country</label>
                                        <div class="col-md-9">
                                        {!! Form::select('country',DB::table('countries')->pluck('name','code'),
                                            "ZW", ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                        <!--<div class="form-control-focus"></div>-->
                                            {!! $errors->first('country','<span class="font-red-mint validation-error">:message</span>')!!}
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

