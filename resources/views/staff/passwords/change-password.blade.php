@extends("layouts.staff-master")

@section("pageTitle","Change Account Password")

@section("headerTitle","Update Account Password")

@section('content')
    <section class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title"> Update Your Account's Password</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                        </div>
                    </div>
                </div>
                <div class="card-content" id="programmeThing">

                    <div class="card-body">
                        <!-- Create New User -->
                        <div class="card-text">
                            <p>Please provide the you current password and the new password you would like to set.</p>
                        </div>
                        @include("layouts.partials.notifications")
                        <form class="form form-horizontal form-bordered" method="post"
                              action="{{route('staff.change-password')}}">
                            {!! csrf_field() !!}
                            <div class="form-body">

                                <div class="form-group row {{ $errors->has('current_password') ? ' has-error' : '' }}">
                                    <label class="col-md-3 label-control" for="current_password">Current
                                        Password</label>
                                    <div class="col-md-9">
                                        {!! Form::password("current_password",["id"=>"current_password",
                                        "class"=>"form-control"]) !!}
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('new_password') ? ' has-error' : '' }}">
                                    <label class="col-md-3 label-control" for="new_password">New Password</label>
                                    <div class="col-md-9">
                                        {!! Form::password("new_password",["id"=>"new_password",
                                        "class"=>"form-control"]) !!}
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                                    <label class="col-md-3 label-control" for="">Confirmation New Password</label>
                                    <div class="col-md-9">
                                        {!! Form::password("new_password_confirmation",["id"=>"new_password_confirmation",
                                        "class"=>"form-control"]) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> Update Password
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


