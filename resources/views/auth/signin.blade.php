@extends("layouts.bauth")

@section("pageTitle","Login")

@section('main-card')
    <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
        <div class="card-header border-0">
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
            {{--<span>OR Using Account Details</span>--}}
            {{--</p>--}}
            <div class="card-body">
                <div class="card-text">
                    <h3 class="text-center text-bold-500">Login</h3>
                    <p class="text-justify">Please provide your National ID and Password to login to your account. If
                        you don't have an account click on the register button at the bottom.</p>
                </div>
                @if(count($errors->all()) > 0)
                    @foreach($errors->all() as $error)
                        <div class="alert round bg-danger alert-icon-left alert-dismissible mb-2"
                             role="alert">
                            <span class="alert-icon"><i class="la la-exclamation-triangle"></i></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{$error}}
                        </div>
                    @endforeach
                @endif

                @if(session()->has("success"))
                    <div class="alert round bg-success alert-icon-left alert-dismissible mb-2" role="alert">
                        <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {{session("success")}}
                    </div>
                @endif
                <form class="form-horizontal" method="post" action="{{route('p.login')}}" novalidate>
                    {!! csrf_field() !!}
                    <fieldset class="form-group form-group-style">
                        <label for="national_id"><i class="ft-user"></i> Your National ID</label>
                        <input name="national_id" type="text" class="form-control" id="national_id"
                               value="{{old("national_id")}}" placeholder="99-999999X99" required>
                    </fieldset>
                    <fieldset class="form-group form-group-style">
                        <label for="user-password"><i class="la la-key"></i> Your Password</label>
                        <input name="password" type="password" class="form-control" id="user-password"
                               placeholder="Password"
                               required>
                    </fieldset>
                    <div class="form-group row">
                        <div class="col-md-6 col-12 text-center text-sm-left">
                            <fieldset>
                                <input name="remember" type="checkbox" id="remember-me" class="chk-remember">
                                <label for="remember-me"> Remember Me</label>
                            </fieldset>
                        </div>
                        <div class="col-md-6 col-12 float-sm-left text-center text-sm-right"><a
                                    href="{{route('password.request')}}" class="card-link">Forgot
                                Password?</a></div>
                    </div>
                    <button type="submit" class="btn btn-outline-info btn-block"><i
                                class="ft-unlock"></i> Login
                    </button>
                </form>
            </div>
            <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                <span>Don't have an account ?</span>
            </p>
            <div class="card-body text-center">
                <a href="{{route('register')}}" class="btn btn-outline-danger btn-block mb-1"><i
                            class="ft-user"></i> Register</a>
            </div>
        </div>
    </div>
@endsection