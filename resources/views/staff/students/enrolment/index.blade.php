@extends("layouts.staff-master")

@section("pageTitle","Student Enrolment")

@section("headerTitle","Student Enrolment")


@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Student Enrolment</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h4>What would you like to do today?</h4>
                            </div>
                            <div class="col-md-6 offset-md-3">
                                <a href="{{route('staff.students.enrol')}}"
                                   class="btn mb-2 btn-success btn-lg btn-block">Create Enrolment</a>
                                <a href="{{route('staff.students.view-enrolment-edit')}}"
                                   class="btn mb-2 btn-warning btn-lg btn-block">Edit Enrolment</a>
                                @if(auth()->user()->user_type == "admin")
                                    <a href="{{route('staff.students.get-enrolment')}}"
                                       class="btn mb-2 btn-primary btn-lg btn-block">Reprint Enrolment Letter</a>
                                @endif
                                <a href="{{route('staff.students.enrolment-view')}}"
                                   class="btn mb-2 btn-secondary btn-lg btn-block">View Enrolments</a>
                            </div>
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


