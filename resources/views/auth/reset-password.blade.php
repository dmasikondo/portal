@extends("layouts.bauth")

@section("pageTitle","Reset Passowrd")

@section('main-card')
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
                    <h3 class="text-center">Reset Account Password</h3>
                    <p>Your details have been verified. Please reset your account password. </p>
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

                <form class="form-horizontal" method="post" action="{{route('password.update')}}" novalidate>
                    {!! csrf_field() !!}
                    <input type="hidden" name="token" value="{{$token}}">
                    <fieldset class="form-group position-relative has-icon-left">
                        <input name="national_id" type="text" class="form-control" id="national_id"
                               placeholder="Your National Id">
                        <div class="form-control-position">
                            <i class="la la-user"></i>
                        </div>
                    </fieldset>

                    <fieldset class="form-group position-relative has-icon-left">
                        <input name="password" type="password" class="form-control" id="password"
                               placeholder="Your Password">
                        <div class="form-control-position">
                            <i class="la la-key"></i>
                        </div>
                    </fieldset>

                    <fieldset class="form-group position-relative has-icon-left">
                        <input name="password_confirmation" type="password" class="form-control"
                               id="password_confirmation" placeholder="Confirm Your Password" required>
                        <div class="form-control-position">
                            <i class="la la-key"></i>
                        </div>
                    </fieldset>


                    <button type="submit" class="btn btn-outline-info btn-block"><i class="ft-"></i> Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection