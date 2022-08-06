@extends("layouts.staff-master")

@section("pageTitle","Student Registration")

@section("headerTitle","Student Registration")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Student Details</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if (session('status'))
                                    <div class="alert round bg-success alert-icon-left alert-dismissible mb-2"
                                         role="alert">
                                        <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        {{session("status")}}
                                    </div>
                                @endif
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
        </div>
    </section>
    <section class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <form class="form form-horizontal form-bordered" method="post"
                                      action="{{route('staff.student-registration.store',["user"=>$user->id])}}">
                                    {!! csrf_field() !!}
                                    <div class="form-body">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Student Balance</label>
                                            <div class="col-md-9 form-text text-center text-bold-700">
                                                {{displayMoney($transactions->acc_balance)}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="enrolment">Enrolment</label>
                                            <div class="col-md-9">
                                                <select name="enrolment" id="enrolment" class="form-control">
                                                    @foreach($enrolment as $enrol)
                                                        <option value="{{$enrol->id}}">{{$enrol->qualification->name}}
                                                            - {{$enrol->programme->name}}</option>
                                                    @endforeach
                                                </select>
                                                <!--<div class="form-control-focus"></div>-->
                                            </div>
                                        </div>
                                        {{--<div class="form-group row">--}}
                                        {{--<label class="col-md-3 label-control" for="level">Level</label>--}}
                                        {{--<div class="col-md-9">--}}
                                        {{--<select name="level" id="level" class="form-control">--}}
                                        {{--<option value="1">1</option>--}}
                                        {{--<option value="2">2</option>--}}
                                        {{--<option value="3">3</option>--}}
                                        {{--</select>--}}
                                        {{--<!--<div class="form-control-focus"></div>-->--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group row">--}}
                                        {{--<label class="col-md-3 label-control" for="term">Term</label>--}}
                                        {{--<div class="col-md-9">--}}
                                        {{--<select name="term" id="term" class="form-control">--}}
                                        {{--<option value="1">1</option>--}}
                                        {{--<option value="2">2</option>--}}
                                        {{--<option value="3">3</option>--}}
                                        {{--</select>--}}
                                        {{--<!--<div class="form-control-focus"></div>-->--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="registration_period">Registration
                                                Period</label>
                                            <div class="col-md-9">
                                                <select name="registration_period" id="registration_period"
                                                        class="form-control">
                                                    @foreach($registration_periods as $key=>$value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                <!--<div class="form-control-focus"></div>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button class="btn mb-2 btn-success btn-lg btn-block">Register Student
                                        </button>
                                        <a href="{{route('staff.student-registration.index')}}"
                                           class="btn mb-2 btn-secondary btn-lg btn-block">Cancel</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection




