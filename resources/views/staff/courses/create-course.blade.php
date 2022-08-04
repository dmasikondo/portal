@extends("layouts.staff-master")

@section("pageTitle","Create Course")

@section("headerTitle","Create Course")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">
                            <a href="{{route("staff.courses")}}" class="btn btn-icon btn-light mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            Create Course</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                        </div>
                    </div>
                </div>
                <div class="card-content" id="programmeThing">

                    <div class="card-body">
                        <!-- Create New User -->
                        <div class="card-text">
                            <p>Please provide course details.</p>
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
                              action="{{route('staff.students.enrol.store')}}">
                            {!! csrf_field() !!}
                            <div class="form-body">

                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="form_control_1">Department</label>
                                    <div class="col-md-9">
                                        {!! Form::select('department', $departments,null,
                                         ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="form_control_1">Qualification</label>
                                    <div class="col-md-9">
                                        {!! Form::select('qualification', $qualifications,null,
                                     ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label class="col-md-3 label-control" for="course_title">Course Title</label>
                                    <div class="col-md-9">
                                        {!! Form::text("course_title",null,["id"=>"course_title","placeholder"=>"Course Title","class"=>"form-control"]) !!}
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('surname') ? ' has-error' : '' }}">
                                    <label class="col-md-3 label-control" for="course_length">Course Length</label>
                                    <div class="col-md-9">
                                        {!! Form::number("course_length",null,["id"=>"course_length","placeholder"=>"Course Length","class"=>"form-control"]) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions right">
                                <a href="{{route("staff.courses")}}" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



