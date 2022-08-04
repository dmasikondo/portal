@extends("layouts.staff-master")

@section("pageTitle","Allocate Room to Student")

@section("headerTitle","Accommodation")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">
                            <a href="{{route('staff.accommodation.hostel-rooms',["hostel"=>$bed->room->hostel_id])}}"
                               class="btn btn-sm btn-secondary mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            Allocate Room To Student</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                        </div>
                    </div>
                </div>
                <div class="card-content" id="programmeThing">

                    <div class="card-body">
                        <div class="card-text">
                            <p>Please provide the Student No, to retrieve profile.</p>
                        </div>
                        @include("layouts.partials.notifications")
                        <form class="form form-horizontal form-bordered" method="post"
                              action="{{route('staff.accommodation.allocate-student',["bed_id"=>$bed->id])}}">
                            {!! csrf_field() !!}
                            <div class="form-body">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="enrolment">Hostel</label>
                                    <div class="col-md-9 form-text text-center text-bold-700">
                                        {{$bed->room->hostel->name}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="level">Room</label>
                                    <div class="col-md-9 form-text text-center text-bold-700">
                                        {{$bed->room->name}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="term">Bed</label>
                                    <div class="col-md-9 form-text text-center text-bold-700">
                                        {{$bed->bed_count}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="term">Gender</label>
                                    <div class="col-md-9 form-text text-center text-bold-700">
                                        {{$bed->room->gender}}
                                    </div>
                                </div>

                                <div class="form-group row last {{ $errors->has('student_no') ? ' has-error' : '' }}">
                                    <label class="col-md-3 label-control" for="national_id">Student No</label>
                                    <div class="col-md-9">
                                        <input name="student_no" type="text" class="form-control"
                                               value="{{old("student_no")}}">
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> Retrieve Profile
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


