@extends("layouts.staff-master")

@section("pageTitle","Update Enrolled Student")

@section("headerTitle","Update Enrolled Student")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">
                            <a href="{{route("staff.students.enrolment")}}" class="btn btn-icon btn-light mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            Update Enrolled Student</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                        </div>
                    </div>
                </div>
                <div class="card-content" id="programmeThing">

                    <div class="card-body">
                        <!-- Create New User -->
                        <div class="card-text">
                            <p>Please provide the National ID details.</p>
                        </div>
                        @include("layouts.partials.notifications")
                        <form class="form form-horizontal form-bordered" method="post"
                              action="{{route('staff.students.get-enrolment.ps',["loc"=>"update"])}}">
                            {!! csrf_field() !!}
                            <div class="form-body">

                                <div class="form-group row last {{ $errors->has('national_id') ? ' has-error' : '' }}">
                                    <label class="col-md-3 label-control" for="national_id">National ID</label>
                                    <div class="col-md-9">
                                        <input name="national_id" type="text" class="form-control"
                                               value="{{old("national_id")}}">
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> Search
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


