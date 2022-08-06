@extends("layouts.staff-master")

@section("pageTitle","Student Enrolment")

@section("headerTitle",((is_null(request('search')))?"View Enrolled Student":"Search Results for \"".request('search')."\"..."))

@push('pageStyles')
    <meta name="csrf_token" content="{{csrf_token()}}">
    <meta name="enrol_student_url" content="{{route('staff.students.enrol.store')}}">
@endpush

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">

                        <h4 class="card-title">
                            <a href="{{route("staff.students.enrolment")}}" class="btn btn-icon btn-light mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            View Enrolled Students</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <a class="btn btn-info"
                               href="{{route('staff.students.enrolment-download',request()->except("page"))}}"><i
                                        class="la la-download"></i>
                                Download CSV
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        @include("layouts.partials.notifications")

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

                                <div class="row mx-auto">
                                    <div class="col-md-5">
                                        <div class="row">

                                            @php
                                                function pad($input)
                                                {
                                                    return sprintf("%02d", $input);
                                                }
                                            @endphp

                                            <div class="col-md-3">
                                                {!! Form::select('from_day',
                                                ([""=>"Day"]+array_combine(array_map('pad', range(1,31)),range(1,31)))
                                                ,request("from_day"),['id'=>'from_day',"class"=>"form-control"]) !!}
                                            </div>

                                            <div class="col-md-5">
                                                {!! Form::select('from_month',
                                                ([""=>"Month"]+array_reduce(array_map('pad', range(1,12)),function($rslt,$m){ $rslt[$m] = date('F',mktime(0,0,0,$m,10)); return $rslt; })),
                                                request("from_month"),['id'=>'from_month',"class"=>"form-control"]) !!}
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::select('from_year',
                                                ([""=>"Year"]+array_combine(range(2018,(date('Y')+2)),range(2018,(date('Y')+2)))),
                                                request("from_year"),['id'=>'from_year',"class"=>"form-control"]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center py-1"><strong>TO</strong></div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-3">
                                                {!! Form::select('to_day',
                                                ([""=>"Day"]+array_combine(array_map('pad', range(1,31)),range(1,31)))
                                                ,request("to_day"),['id'=>'to_day',"class"=>"form-control"]) !!}
                                            </div>

                                            <div class="col-md-5">
                                                {!! Form::select('to_month',
                                                ([""=>"Month"]+array_reduce(array_map('pad', range(1,12)),function($rslt,$m){ $rslt[$m] = date('F',mktime(0,0,0,$m,10)); return $rslt; })),
                                                request("to_month"),['id'=>'to_month',"class"=>"form-control"]) !!}
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::select('to_year',
                                                ([""=>"Year"]+array_combine(range(2018,(date('Y')+2)),range(2018,(date('Y')+2)))),
                                                request("to_year"),['id'=>'to_year',"class"=>"form-control"]) !!}
                                            </div>
                                        </div>
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
                                    <th>Title</th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Gender</th>
                                    <th>National ID</th>
                                    <th>Date Of Birth</th>
                                    <th>Programme</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="p-0" colspan="9">
                                        <a href="{{route("staff.students.enrol")}}"
                                           class="btn btn-block btn-secondary add-more-btn"><i
                                                    class="la la-plus"></i>
                                            Enroll New Students
                                        </a>
                                    </td>
                                </tr>
                                @forelse($enrolled_students as $student)
                                    <tr class="main-info">
                                        <td>{{$student->student_no}}</td>
                                        <td>{{$student->title}}</td>
                                        <td>{{$student->first_name}}</td>
                                        <td>{{$student->last_name}}</td>
                                        <td>{{$student->gender}}</td>
                                        <td>{{$student->national_id}}</td>
                                        <td>{{$student->date_of_birth}}</td>
                                        <td>{{$student->programme->name}}</td>
                                        <td>
                                            <a href="{{route('staff.students.enrolled.offer',["id"=>$student->id])}}"
                                               target="_blank" class="btn btn-block btn-primary">
                                                <i class="la la-envelope"></i> View Offer Letter
                                            </a>
                                            <a href="{{route('staff.students.enrolment.edit',["id"=>$student->id])}}"
                                               target="_blank" class="btn btn-block btn-warning">
                                                <i class="la la-pencil"></i> Edit Enrolment
                                            </a>

                                            @if(auth("staff_user")->user()->user_type == "admin")
                                                <a href="{{route('staff.students.enrolment.confirm-delete',["id"=>$student->id])}}"
                                                   target="_blank" class="btn btn-block btn-danger">
                                                    <i class="la la-pencil"></i> Delete Enrolment
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No Enrolled Students</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Title</th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Gender</th>
                                    <th>National ID</th>
                                    <th>Date Of Birth</th>
                                    <th>Programme</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $enrolled_students->appends(Request::except(["page"]))->render() !!}
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


