@extends("layouts.staff-master")

@section("pageTitle","Allocate Student to room")

@section("headerTitle","Accommodation")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">
                            <a href="{{route("staff.accommodation.search-student",["bed_id"=>$bed->id])}}"
                               class="btn btn-sm btn-secondary mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            Student Details</h4>
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

                                <div class="form-group row">
                                    <label class="col-md-5 label-control">Gender</label>
                                    <div class="col-md-7">
                                        {{$user->personalInformation->gender}}
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
                                      action="{{route("staff.accommodation.allocate-student.commit",
                                      ["bed_id"=>$bed->id,"user"=>$user->id])}}">
                                    {!! csrf_field() !!}
                                    <div class="form-body">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Student Balance</label>
                                            <div class="col-md-9 form-text text-center text-bold-700">
                                                {{displayMoney($transactions->acc_balance)}}
                                            </div>
                                        </div>
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
                                    </div>
                                    <div class="form-actions">
                                        @if(strtoupper($bed->room->gender) == strtoupper($user->personalInformation->gender))
                                            <button class="btn mb-2 btn-success btn-lg btn-block">Allocate Student
                                            </button>
                                        @else
                                            <div class="alert bg-danger alert-icon-left mb-2" role="alert">
                                                <span class="alert-icon">
                                                    <i class="la la-exclamation-triangle"></i>
                                                </span>
                                                </button>
                                                Student cannot be allocated to this room as it is
                                                for {{$bed->room->gender}} students.
                                            </div>
                                        @endif
                                        <a href="{{route('staff.accommodation.hostel-rooms',["hostel"=>$bed->room->hostel->id])}}"
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




