@extends("layouts.staff-master")

@section("pageTitle",((is_null(request('search')))?"All Students":"Search Results for \"".request('search')."\"..."))

@section("headerTitle",((is_null(request('search')))?"All Students":"Search Results for \"".request('search')."\"..."))

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">
                            @if(!is_null(request("department")) || !is_null(request("course")))
                                @if(!is_null(request("course")))
                                    @php($course = \App\Programme::find(request("course")))
                                    <strong>{{is_null($course)?"Undefined Course":$course->name}} Students</strong>
                                @else
                                    <strong>{{$departments[request("department")]}} Students</strong>
                                @endif
                            @else
                                All Students
                            @endif
                        </h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            @if (\Auth::guard("staff_user")->user()->user_type == "admin")
                                <a class="btn btn-secondary" href="{{route("staff.student-finder")}}"><i
                                            class="la la-question-circle"></i>
                                    Account Create Errors
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        <form class="form row mb-4 py-3 px-2" id="searchBox" style="border: 2px dashed #ccc;">

                            <div class="col-12">
                                <div class="row mx-auto">
                                    <div class="form-group mb-1 col-sm-12 col-md-4">
                                        <label class="label-control" for="form_control_1">Student Particular</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <select class="btn btn-secondary" name="field">
                                                    <option value="full_name"
                                                            {{request("field")=="full_name"?"selected":""}}>
                                                        Full Name
                                                    </option>
                                                    <option value="national_id"
                                                            {{request("field")=="national_id"?"selected":""}}>
                                                        National ID
                                                    </option>
                                                    <option value="student_number"
                                                            {{request("field")=="student_number"?"selected":""}}>
                                                        Student Number
                                                    </option>

                                                </select>
                                            </div>
                                            <input name="search" type="text" class="form-control"
                                                   placeholder="Search..."
                                                   aria-describedby="button-addon2" value="{{request('search')}}">

                                        </div>
                                    </div>

                                    <div class="form-group mb-1 col-sm-12 col-md-3">
                                        <label class="label-control" for="form_control_1">Department</label>
                                        {!! Form::select('department', ((count($departments)>1)?[""=>"All"]:[])+$departments,request("department"),
                                         ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                    </div>

                                    <div class="form-group mb-1 col-sm-12 col-md-4">
                                        <label class="label-control" for="form_control_1">Course</label>
                                        {!! Form::select('course',
                                    ((!is_null(request("department")))?
                                    [""=>"All Courses"]+\App\Programme::where("departmentid",request("department"))->pluck('name',"id")->toArray():[]),
                                    request("course"),
                                    ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                        {{--                                        <select name="course" id="form_control_1" class="form-control"--}}
                                        {{--                                                disabled>--}}
                                        {{--                                        </select>--}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary" type="submit"><i class="la la-search"></i>
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Task List table -->
                        <div class="table-responsive">
                            <table class="table table-white-space table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>National ID</th>
                                    <th>Updated?</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->first_name}}</td>
                                        <td>{{$user->last_name}}</td>
                                        <td>{{$user->national_id}}</td>
                                        <td>{{($user->update_record=="Y")?"No":"Yes"}}</td>
                                        <td><a class="btn btn-primary"
                                               href="{{route('staff.students.view',["user"=>$user->id])}}">View</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>National ID</th>
                                    <th>Updated?</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $users->appends(Request::only(["field","search",'department','course']))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageJavascript')
    <script>
        $(document).ready(function () {
            if ($('select[name="course"]').has('option').length < 1) {
                getCourseList($('select[name="department"]'));
            }

            $('select[name="department"]').on("change", function (e) {
                getCourseList($(this));
            });
        });

        function getCourseList($departElem) {
            // let $qualification = $('select[name="qualification"]');
            let $course = $('select[name="course"]');
            $course.prop("disabled", true);
            $course.empty().append('<option value="">All Courses</option>');

            $("#searchBox").block({
                message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
                // timeout: 2000, //unblock after 2 seconds
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });

            $.get("{{route('json.depProgrammeList')}}?department=" + $departElem.val(), function (data) {
                if (data.length > 0) {
                    data.forEach(function (item, index) {
                        $course.append('<option value="' + item.id + '">' + item.name + '</option>');
                    })
                    $course.prop("disabled", false);
                }
            });

            $("#searchBox").unblock();
        }
    </script>
@endpush
