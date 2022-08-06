@extends('layouts.master')

@section('pageTitle',"Stage 7: Academic Information")

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
                    <div class="card-content collpase show" id="programmeThing">
                        <div class="card-body">
                            <div class="card-text">
                                <p>Please select the department your course is under. Upon selection, the qualification
                                    field will be enabled and you will be able to select the qualification you are
                                    pursuing and from the please select the course.</p>
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
                                  action="{{route('urp.currentAcademic')}}">
                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-certificate"></i> Course</h4>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="form_control_1">What department are
                                            you in?</label>
                                        <div class="col-md-9">
                                        {!! Form::select('department', array_merge([""=>"Select Your Department"],DB::table("department")->pluck('name','id')->all()),null,
                                         ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                        <!--<div class="form-control-focus"></div>-->
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="form_control_1">What qualification
                                            are you pursuing?</label>
                                        <div class="col-md-9">
                                            <select name="qualification" id="form_control_1" class="form-control">
                                                <option value=""></option>
                                                @foreach(\App\Qualification::all() as $qualification)
                                                    <option value="{{$qualification->id}}">{{$qualification->name}}</option>
                                                @endforeach
                                            </select>
                                            <!--<div class="form-control-focus"></div>-->
                                        </div>
                                    </div>

                                    <div class="form-group row last">
                                        <label class="col-md-3 label-control" for="form_control_1">What course
                                            are you pursuing?</label>
                                        <div class="col-md-9">
                                            <select name="course" id="form_control_1" class="form-control">
                                                <option value=""></option>
                                                @foreach(\App\Programme::all() as $programme)
                                                    <option value="{{$programme->id}}">{{$programme->name}}</option>
                                                @endforeach
                                            </select>
                                            <!--<div class="form-control-focus"></div>-->
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
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
    <script>
        $(document).ready(function () {
            let $qualification = $('select[name="qualification"]');
            let $course = $('select[name="course"]');
            $qualification.prop("disabled", true);
            $course.prop("disabled", true);
            var $department_id;
            $('select[name="department"]').on("change", function (e) {
                $qualification.prop("disabled", true);
                $course.prop("disabled", true);
                $qualification.empty().append('<option value="">Select Your Qualification</option>');
                $course.empty().append('<option value=""></option>');
                $department_id = parseInt($(this).val()) + 1;

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

            });

            $('select[name="qualification"]').on("change", function (e) {
                // let $qualification = $('select[name="qualification"]');
                let $course = $('select[name="course"]');
                $course.prop("disabled", true);
                $course.empty().append('<option value="">Select Your Course</option>');

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
                        data.forEach(function (item, index) {
                            $course.append('<option value="' + item.id + '">' + item.name + '</option>');
                        })
                        $course.prop("disabled", false);
                    }
                });

                $("#programmeThing").unblock();

            });
        });
    </script>
@endpush
