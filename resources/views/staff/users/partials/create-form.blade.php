<div class="form-group row {{ $errors->has('first_name') ? ' has-error' : '' }}">
    <label class="col-md-3 label-control" for="form_control_1">First Name</label>
    <div class="col-md-9">
        {!! Form::text("first_name",null,["id"=>"first_name","placeholder"=>"First Name","class"=>"form-control"]) !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('last_name') ? ' has-error' : '' }}">
    <label class="col-md-3 label-control" for="last_name">Last Name</label>
    <div class="col-md-9">
        {!! Form::text("last_name",null,["id"=>"last_name","placeholder"=>"Last Name","class"=>"form-control"]) !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
    <label class="col-md-3 label-control" for="email">E-mail</label>
    <div class="col-md-9">
        {!! Form::email("email",null,["id"=>"email","placeholder"=>"E-mail","class"=>"form-control"]) !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('username') ? ' has-error' : '' }}">
    <label class="col-md-3 label-control" for="username">Username</label>
    <div class="col-md-9">
        {!! Form::text("username",null,["id"=>"username","placeholder"=>"Username","class"=>"form-control"]) !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('password') ? ' has-error' : '' }}">
    <label class="col-md-3 label-control" for="password">Password</label>
    <div class="col-md-9">
        {!! Form::password("password",["id"=>"password","placeholder"=>"Password","class"=>"form-control"]) !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('user_type') ? ' has-error' : '' }}">
    <label class="col-md-3 label-control" for="user_type">User Type</label>
    <div class="col-md-9">
        {!! Form::select("user_type",["admin"=>"Administrative User","enrolment_user"=>"Enrolment User"],null,["id"=>"user_type","placeholder"=>"Select User Type","class"=>"form-control"]) !!}
    </div>
</div>

<div class="form-group department-selector" style="display: none;">
    <div class="col-md-9 offset-md-3">
        {!! Form::select('departments[]',DB::table("department")->pluck('name','id')->all(),
        ((isset($user))?\App\StaffUserEnrolmentPermissions::where('staff_user_id',$user->id)->pluck("department_id")->all():null),
                                             ["class"=>"duallistbox", "multiple"=>"multiple", "size"=>"10"]) !!}
    </div>
</div>

@push('pageStyles')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/listbox/bootstrap-duallistbox.min.css">

    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/forms/dual-listbox.css">
@endpush

@push("pageJavascript")
    <script src="/app-assets/vendors/js/forms/listbox/jquery.bootstrap-duallistbox.min.js"
            type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            console.log("Test")
            displayDepartmentSelector("#user_type");

            $('.duallistbox').bootstrapDualListbox({
                nonSelectedListLabel: 'All Departments',
                selectedListLabel: 'Departments User Can Enroll',
            });

            $("#user_type").change(function () {
                displayDepartmentSelector(this);
            });

            function displayDepartmentSelector(elem) {
                if ($(elem).find(":selected").val() == "enrolment_user")
                    $('.department-selector').show();
                else
                    $('.department-selector').hide();
            }
        });
    </script>
@endpush