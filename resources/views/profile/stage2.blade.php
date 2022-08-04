@extends('layouts.master')

@section('pageTitle',"Stage 2: Origin Information")

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
                                  action="{{route('urp.stage2')}}">
                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-globe"></i> Origin Info</h4>

                                    <div class="form-group row {{ $errors->has('nationality') ? ' has-error' : '' }}">
                                        <label class="col-md-3 label-control" for="form_control_1">Nationality</label>
                                        <div class="col-md-9">
                                        {!! Form::select('nationality',DB::table('countries')->pluck('name','code'),
                                            "ZW", ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                        <!--<div class="form-control-focus"></div>-->
                                            {!! $errors->first('nationality','<span class="font-red-mint validation-error">:message</span>')!!}
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('birth_country') ? ' has-error' : '' }}">
                                        <label class="col-md-3 label-control" for="birth_country">Country Of
                                            Birth</label>
                                        <div class="col-md-9">
                                        {!! Form::select('birth_country',DB::table('countries')->pluck('name','code'),
                                            "ZW", ["class"=>"form-control", "id"=>"birth_country"]) !!}
                                        <!--<div class="form-control-focus"></div>-->
                                            {!! $errors->first('birth_country','<span class="font-red-mint validation-error">:message</span>')!!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="birth_town">City/Town Of
                                            Birth</label>
                                        <div class="col-md-9">
                                            <input type="text" id="birth_town" class="form-control"
                                                   placeholder="City/Town You Were Born"
                                                   name="birth_town"
                                                   value="{{Session::hasOldInput("birth_town")?Session::getOldInput("birth_town"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="birth_town">Hometown</label>
                                        <div class="col-md-9">
                                            <input type="text" id="hometown" class="form-control"
                                                   placeholder="Your Hometown"
                                                   name="hometown"
                                                   value="{{Session::hasOldInput("hometown")?Session::getOldInput("hometown"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('race') ? ' issue' : '' }}">
                                        <label class="col-md-3 label-control" for="titleSt">Race</label>
                                        <div class="col-md-9">
                                        {!! Form::select('race',["Black"=>"Black","Asian"=>"Asian","White"=>"White"],null,["class"=>"form-control", "id"=>"titleSt"]) !!}
                                        {!! $errors->first('race','<span class="font-red-mint validation-error">:message</span>')!!}
                                        <!--<div class="form-control-focus"></div>-->
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('religion') ? ' issue' : '' }}">
                                        <label class="col-md-3 label-control" for="religion">Religion</label>
                                        <div class="col-md-9">
                                        {!! Form::select('religion',
                                        ["Christianity"=>"Christianity",
                                        "Islam"=>"Islam",
                                        "Hinduism"=>"Hinduism",
                                        "Traditional religions"=>"Traditional religions",
                                        "None"=>"None"],null,["class"=>"form-control", "id"=>"religion"]) !!}
                                        {!! $errors->first('religion','<span class="font-red-mint validation-error">:message</span>')!!}
                                        <!--<div class="form-control-focus"></div>-->
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="denominations">Denomination</label>
                                        <div class="col-md-9">
                                            <input type="text" id="denominations" class="form-control"
                                                   placeholder="Denomination"
                                                   name="denomination"
                                                   value="{{Session::hasOldInput("denomination")?Session::getOldInput("denomination"):""}}">
                                            <p class="text-left mb-0">
                                                <small class="text-muted">This is a subgroup within a religion. Example:
                                                    Methodist, Roman Catholic.
                                                </small>
                                            </p>
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

