@extends("layouts.staff-master")

@section("pageTitle","Student Enrolment")

@section("headerTitle","Student Enrolment")

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
                            Enrol Students</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        <h4>Instructions</h4>
                        <ul>
                            <li>The field that is in focus has a blue border around it.</li>
                            <li>You can press <strong>F2</strong> to add a new row.</li>
                            <li>You can press <strong>F4</strong> to save the row where your cursor is. F4 has no effect
                                is no row is in focus(i.e has a cursor)
                            </li>
                            <li>You can press <strong>F7</strong> to save the row where your cursor is and add a new
                                row if saving was successfully.
                            </li>
                            <li>You can press <strong>TAB</strong> to move fields to your right.</li>
                            <li>You can use <strong>Arrows(&uarr;,&rarr;,&darr;,&larr;)/Number</strong> to in the date
                                of birth field.
                            </li>
                            <li>Upon selecting department, the qualification becomes selectable and upon selecting a
                                qualification course becomes selectable.
                            </li>
                        </ul>
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
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                @foreach(range(0,1) as $arr)
                                    <tbody @if($loop->first) style="display: none;" id="ogRow" @endif>
                                    <tr class="error-row" style="display: none;">
                                        <td colspan="8" class="errors"></td>
                                    </tr>
                                    <tr class="main-info">
                                        <td></td>
                                        <td class="p-1">
                                            {!! Form::select('title',["Mr"=>"Mr","Mrs"=>"Mrs","Miss"=>"Miss","Dr"=>"Dr","Ms"=>"Ms","Rev"=>"Rev","Sr"=>"Sr","Prof"=>"Prof"],null,["class"=>"form-control", "id"=>"titleSt"]) !!}

                                        </td>
                                        <td class="p-1">
                                            <input name="first_name" type="text" class="form-control">

                                        </td>
                                        <td class="p-1">
                                            <input name="surname" type="text" class="form-control">
                                        </td>
                                        <td class="p-1">
                                            {!! Form::select('gender',["Male"=>"Male","Female"=>"Female"],null,["class"=>"form-control", "id"=>"genderSt"]) !!}
                                        </td>
                                        <td class="p-1">
                                            <fieldset class="form-group">
                                                <input name="national_id" type="text" class="form-control">
                                            </fieldset>
                                        </td>
                                        <td class="p-1">
                                            <input name="date_of_birth" type="date" class="form-control" id="date">
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr class="child">
                                        <td colspan="7">
                                            <div class="form row programmeThing">
                                                <div class="form-group mb-1 col-sm-12 col-md-3">
                                                    <label for="department">Department</label>
                                                    <br>
                                                    {!! Form::select('department', array_merge([""=>"Select Department"],DB::table("department")->pluck('name','id')->all()),null,
                                             ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                                </div>
                                                <div class="form-group mb-1 col-sm-12 col-md-2">
                                                    <label for="qualification">Qualification</label>
                                                    <br>
                                                    <select name="qualification" id="qualification" class="form-control"
                                                            disabled>
                                                        {{--<option value=""></option>--}}
                                                    </select>
                                                </div>
                                                <div class="form-group mb-1 col-sm-12 col-md-5">
                                                    <label for="course" class="cursor-pointer">Course</label>
                                                    <br>
                                                    <select name="course" id="course" class="form-control" disabled>
                                                        {{--<option value=""></option>--}}
                                                    </select>
                                                </div>

                                                <div class="form-group mb-1 col-sm-12 col-md-2">
                                                    <label for="mode_of_entry">Mode Of Entry</label>
                                                    <br>
                                                    <select name="mode_of_entry" class="form-control"
                                                            id="mode_of_entry">
                                                        <option>Select Mode Of Entry</option>
                                                        <option value="full_time">Full Time</option>
                                                        <option value="part_time">Part Time</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-block btn-primary save-row"><i
                                                        class="la la-save"></i> Save
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                @endforeach
                                <tfoot>
                                <tr>
                                    <td class="p-0" colspan="8">
                                        <button class="btn btn-block btn-secondary add-more-btn"><i
                                                    class="la la-plus"></i>
                                            Add Another Row
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Title</th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Gender</th>
                                    <th>National ID</th>
                                    <th>Date Of Birth</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageJavascript')
    <script src="/app-assets/js/core/student.enrolment.js" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            var $department_id;

            $('table').on("change", 'select[name="department"]', function (e) {
                let programmingThing = $(this).closest(".programmeThing");
                let $qualification = programmingThing.find('select[name="qualification"]');
                let $course = programmingThing.find('select[name="course"]');
                $qualification.prop("disabled", true);
                $course.prop("disabled", true);
                $qualification.empty().append('<option value="">Select Your Qualification</option>');
                $course.empty().append('<option value=""></option>');
                $department_id = parseInt($(this).val()) + 1;

                if (!isNaN($department_id)) {
                    programmingThing.block({
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

                    $.get("{{route('json.qualificationList')}}?department=" + $department_id, function (data) {
                        if (data.length > 0) {
                            data.forEach(function (item, index) {
                                $qualification.append('<option value="' + item.id + '">' + item.name + '</option>');
                            })
                            $qualification.prop("disabled", false);
                        }
                    });
                    programmingThing.unblock();
                }

            });

            $('table').on("change", 'select[name="qualification"]', function (e) {
                // let $qualification = $('select[name="qualification"]');
                let programmingThing = $(this).closest(".programmeThing");
                let $course = programmingThing.find('select[name="course"]');
                $course.prop("disabled", true);
                $course.empty().append('<option value="">Select Your Course</option>');

                programmingThing.block({
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

                $.get("{{route('json.programmeList')}}?department=" + $department_id + "&qualification=" + $(this).val(), function (data) {
                    if (data.length > 0) {
                        data.forEach(function (item, index) {
                            $course.append('<option value="' + item.id + '">' + item.name + '</option>');
                        })
                        $course.prop("disabled", false);
                    }
                });

                programmingThing.unblock();

            });
        });
    </script>
@endpush


