@extends("layouts.staff-master")

@section("pageTitle","Update Student Record")

@section("headerTitle","Update Student Record")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">
                            <a href="{{route("staff.student-finder")}}" class="btn btn-icon btn-light mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            Update Student Record</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                        </div>
                    </div>
                </div>
                <div class="card-content" id="programmeThing">

                    <div class="card-body">
                        <!-- Create New User -->
                        <div class="card-text">
                            <p>Please provide student details.</p>
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
                              action="{{route('staff.student-finder.card-edit',["card_id"=>$student->id])}}">
                            {!! csrf_field() !!}
                            <div class="form-body">

                                <div class="form-group row {{ $errors->has('full_name') ? ' has-error' : '' }}">
                                    <label class="col-md-3 label-control" for="full_name">Full Name</label>
                                    <div class="col-md-9">
                                        {!! Form::text("full_name",$student->Name,["id"=>"full_name","placeholder"=>"Full Name","class"=>"form-control"]) !!}
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('student_no') ? ' has-error' : '' }}">
                                    <label class="col-md-3 label-control" for="student_no">Student Number</label>
                                    <div class="col-md-9">
                                        <input name="student_no" type="text" class="form-control"
                                               value="{{old("student_no")?:$student->ucARSTUDENTNO}}">
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('type_of_id') ? ' has-error' : '' }}">
                                    <label class="col-md-3 label-control" for="type_of_id">Type Of ID</label>
                                    <div class="col-md-9">
                                        {!! Form::select('type_of_id',["zim_id"=>"Zimbabwean National ID","foreign_id"=>"Foreign Passport/ID"],null,["class"=>"form-control", "id"=>"type_of_id"]) !!}
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('national_id') ? ' has-error' : '' }}">
                                    <label class="col-md-3 label-control" for="national_id">National ID</label>
                                    <div class="col-md-9">
                                        <input name="national_id" type="text" class="form-control"
                                               value="{{old("national_id")?:$student->Account}}">
                                    </div>
                                </div>

                                {{--                                <div class="form-group row {{ $errors->has('pastel_account') ? ' has-error' : '' }}">--}}
                                {{--                                    <label class="col-md-3 label-control" for="pastel_account">Pastel Account No</label>--}}
                                {{--                                    <div class="col-md-9">--}}
                                {{--                                        <input name="pastel_account" type="text" class="form-control"--}}
                                {{--                                               value="{{old("pastel_account")?:$pastel_account}}">--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                            </div>
                            <div class="form-actions right">
                                <a href="{{route("staff.student-finder")}}" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageJavascript')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}

@endpush


