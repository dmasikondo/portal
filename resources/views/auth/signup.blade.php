@extends("layouts.bauth")

@section("pageTitle","Verify Student")

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
                    <h3 class="text-center text-bold-500">Register</h3>
                    <p class="text-justify">Please provide your <strong>Surname</strong>, <strong>National ID</strong>
                        and <strong>Student
                            ID</strong> for verification purposes. Your National ID should follow the format
                        99-999999X99, that is there shouldn't be any spaces and the only hyphen(-) should be after the
                        first two digits.
                    </p>
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


                <form class="form-horizontal" method="post" action="{{route("p.verify")}}" novalidate>
                    {!! csrf_field() !!}
                    <fieldset class="form-group form-group-style">
                        <label for="surname"><i class="ft-user"></i> Your Surname</label>
                        <input name="surname" type="text" class="form-control" id="surname" placeholder="Surname"
                               value="{{Session::hasOldInput("surname")?Session::getOldInput("surname"):""}}">
                    </fieldset>

                    <fieldset class="form-group form-group-style">
                        <label for="national_id"><i class="la la-slack"></i> Your National ID</label>
                        <input name="national_id" type="text" class="form-control" id="national_id"
                               value="{{old("national_id")}}"
                               placeholder="99-999999X99" required>
                    </fieldset>

                    <fieldset class="form-group form-group-style">
                        <label for="student_id"><i class="ft-credit-card"></i> Your Student ID</label>
                        <input name="student_id" type="text" class="form-control" id="student_id"
                               value="{{old("student_id")}}" placeholder="Student ID" required>
                    </fieldset>

                    <button type="submit" class="btn btn-outline-info btn-block"><i class="ft-check"></i> Verify
                    </button>
                </form>
            </div>
            <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                <span>Already have an account?</span>
            </p>
            <div class="card-body text-center">
                <a href="{{route('login')}}" class="btn btn-outline-danger btn-block mb-1"><i class="ft-unlock"></i>
                    Login</a>
                {{--                <a href="{{route('assistance')}}"> Failing To Register? Click Here</a>--}}
            </div>
        </div>
    </div>
@endsection