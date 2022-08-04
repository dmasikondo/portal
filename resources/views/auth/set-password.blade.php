@extends("layouts.bauth")

@section("pageTitle","Register Student Account")

@section('main-card')
    <style>
        .numbered li {
            font-weight: bold;
            list-style-type: decimal;
        }
    </style>
    <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
        <div class="card-header border-0 pb-0">
            <div class="card-title text-center">
                <img src="/app-assets/images/logo/logo-dark.png" alt="Harare Polytechnic" style="width: 90%;">
            </div>
            {{--<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">--}}
            {{--<span>Easily Using</span>--}}
            {{--</h6>--}}
        </div>
        <div class="card-content">
            {{--<div class="text-center">--}}
            {{--<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook">--}}
            {{--<span class="la la-facebook"></span>--}}
            {{--</a>--}}
            {{--<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter">--}}
            {{--<span class="la la-twitter"></span>--}}
            {{--</a>--}}
            {{--<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin">--}}
            {{--<span class="la la-linkedin font-medium-4"></span>--}}
            {{--</a>--}}
            {{--<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-github">--}}
            {{--<span class="la la-github font-medium-4"></span>--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--<p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">--}}
            {{--<span>OR Using Email</span>--}}
            {{--</p>--}}
            <div class="card-body">
                <div class="card-text">
                    <h3 class="text-center text-bold-500">Set Account Password</h3>
                    <p class="text-justify">Your details have been verified, please fill the form below to create an
                        account.
                    </p>
                    <ol class="numbered">
                        <li>Set a password that you will remember.</li>
                        <li>Use an email address that you can immediately
                            access and ensure that it is correct, as an email will be sent to you in later stages.
                        </li>
                        @if (in_array(\session("student_type"), ["legacy","legacy_id"]))
                            <li>Enter a mobile number that you have access to as a text message will be sent to you.
                            </li>
                        @endif
                    </ol>
                </div>

                @if(count($errors->all()) > 0)
                    @foreach($errors->all() as $error)
                        <div class="alert round bg-danger alert-icon-left alert-dismissible mb-2" role="alert">
                            <span class="alert-icon"><i class="la la-exclamation-triangle"></i></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{$error}}
                        </div>
                    @endforeach
                @endif

                <div class="alert round bg-warning alert-icon-left mb-2"
                     role="alert">
                    <span class="alert-icon"><i class="la la-exclamation-triangle"></i></span>
                    After clicking the "Create Account", you will have an account and will be immediately logged in.
                </div>

                <form class="form-horizontal" method="post" action="{{route('p.register')}}" novalidate>
                    {!! csrf_field() !!}
                    <fieldset class="form-group form-group-style">
                        <label for="email"><i class="ft-at-sign"></i> Your Email</label>
                        <input name="email" type="email" class="form-control" id="email"
                               value="{{old("email")}}" placeholder="me@example.com" required>
                    </fieldset>

                    @if (in_array(\session("student_type"), ["legacy","legacy_id"]))
                        <fieldset class="form-group form-group-style">
                            <label for="cellphone"><i class="ft-phone-call"></i> Your Cellphone</label>
                            <input name="cellphone" type="text" class="form-control" id="cellphone"
                                   value="{{old("cellphone")}}" placeholder="+26377123456" required>
                        </fieldset>
                    @endif

                    <fieldset class="form-group form-group-style">
                        <label for="password"><i class="la la-key"></i> Your Password</label>
                        <input name="password" type="password" class="form-control" id="password"
                               placeholder="Password">
                    </fieldset>
                    <fieldset class="form-group form-group-style">
                        <label for="password"><i class="la la-key"></i> Confirm Your Password</label>
                        <input name="password_confirmation" type="password" class="form-control"
                               id="password_confirmation" placeholder="Password" required>
                    </fieldset>


                    <button type="submit" class="btn btn-outline-info btn-block"><i class="ft-"></i> Create Account
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection