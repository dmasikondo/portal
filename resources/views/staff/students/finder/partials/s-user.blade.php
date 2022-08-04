<div class="alert round bg-success alert-icon-left alert-dismissible mb-2" role="alert">
    <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    These details already have a student account!
</div>

<div class="row">
    <div class="col-md-8 offset-md-2">
        @php($personal = $student_user->personalInformation)
        <div class="form-group row">
            <label class="col-md-5 label-control"
                   for="form_control_1">National ID</label>
            <div class="col-md-7">
                {{$student_user->national_id}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 label-control"
                   for="form_control_1">Student ID</label>
            <div class="col-md-7">
                {{(!is_null($student_user->student_no))?$student_user->student_no : "-"}}
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
                {{$student_user->last_name}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 label-control">First name</label>
            <div class="col-md-7">
                {{$student_user->first_name}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 label-control">Gender</label>
            <div class="col-md-7">
                {{is_null($personal)?"-":$personal->gender}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{route("staff.students.view",["user"=>$student_user->id])}}"
                   class="btn mb-2 btn-success btn-lg btn-block">Go To
                    Student Account</a>
            </div>
        </div>

    </div>
</div>
