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
                {{$student->Account}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 label-control"
                   for="form_control_1">Student ID</label>
            <div class="col-md-7">
                {{(!is_null($student->ucARSTUDENTNO))?$student->ucARSTUDENTNO : "-"}}
            </div>
        </div>


        <div class="form-group row">
            <label class="col-md-5 label-control">Full Name</label>
            <div class="col-md-7">
                {{$student->Name}}
            </div>
        </div>

    </div>
</div>