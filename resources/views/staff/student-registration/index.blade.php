@extends("layouts.staff-master")

@section("pageTitle","Register Student")

@section("headerTitle","Register Student")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{--<a href="{{route("staff.students.enrolment")}}" class="btn btn-icon btn-light mr-1"><i--}}
                            {{--class="la la-chevron-circle-left"></i></a>--}}
                            Register Student</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                        </div>
                    </div>
                </div>
                <div class="card-content" id="programmeThing">

                    <div class="card-body">
                        <!-- Create New User -->
                        <div class="card-text">
                            <p>Please provide the Student No, to retrieve profile.</p>
                        </div>
                        @include("layouts.partials.notifications")
                        <form class="form form-horizontal form-bordered" method="post"
                              action="{{route("staff.student-registration.search")}}">
                            {!! csrf_field() !!}
                            <div class="form-body">

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


