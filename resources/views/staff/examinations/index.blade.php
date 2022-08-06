@extends("layouts.staff-master")

@section("pageTitle", "Examinations")
@section("headerTitle", "Examinations")

@section("content")
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">

                        <h4 class="card-title">Examinations - Home</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        @include("layouts.partials.notifications")
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h4>What would you like to do today?</h4>
                            </div>
                            <div class="col-md-6 offset-md-3">
                                <a href="{{route('staff.examinations.search',["to"=>"view-student"])}}"
                                   class="btn mb-2 btn-success btn-lg btn-block">View Student Record</a>
                                {{--<a href="{{route('staff.students.view-enrolment-edit')}}"--}}
                                {{--class="btn mb-2 btn-warning btn-lg btn-block">Edit Enrolment</a>--}}
                                {{--<a href="{{route('staff.students.get-enrolment')}}"--}}
                                {{--class="btn mb-2 btn-primary btn-lg btn-block">Reprint Enrolment Letter</a>--}}
                                <a href="{{route("staff.examinations.search",["to"=>"clear-student"])}}"
                                   class="btn mb-2 btn-secondary btn-lg btn-block">Clear A Student</a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection