<div class="alert round bg-success alert-icon-left alert-dismissible mb-2" role="alert">
    <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    This student can create an account with the provided details!
</div>

<div class="row">
    <div class="col-md-8 offset-md-2">

        <div class="form-group row">
            <label class="col-md-5 label-control"
                   for="form_control_1">National ID</label>
            <div class="col-md-7">
                {{$student->national_id}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 label-control"
                   for="form_control_1">Student ID</label>
            <div class="col-md-7">
                {{(!is_null($student->student_no))?$student->student_no : "-"}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 label-control">Title</label>
            <div class="col-md-7">
                {{(!is_null($student))?$student->title:"-"}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 label-control">Surname</label>
            <div class="col-md-7">
                {{$student->last_name}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 label-control">First name</label>
            <div class="col-md-7">
                {{$student->first_name}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 label-control">Gender</label>
            <div class="col-md-7">
                {{$student->gender}}
            </div>
        </div>

        {{--        <div class="row">--}}
        {{--            <div class="col-md-12 text-center">--}}
        {{--                <a href="{{route("staff.students.view",["user"=>$student_user->id])}}"--}}
        {{--                   class="btn mb-2 btn-success btn-lg btn-block">Student Account</a>--}}
        {{--            </div>--}}
        {{--        </div>--}}

    </div>
</div>