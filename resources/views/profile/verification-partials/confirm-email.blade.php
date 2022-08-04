@extends('profile.verification-partials.base')

@section("title","Verify E-mail")

@section("content")
    <div class="card-text">
        {{--<div class="alert alert-icon-right alert-info alert-dismissible mb-2"--}}
        {{--role="alert">--}}
        {{--<span class="alert-icon"><i class="la la-info"></i></span>--}}
        {{--<button type="button" class="close" data-dismiss="alert"--}}
        {{--aria-label="Close">--}}
        {{--<span aria-hidden="true">×</span>--}}
        {{--</button>--}}
        {{--<strong>Form Actions On Top And Bottom Center.</strong>--}}
        {{--</div>--}}
        <p class="text-center text-justify">An e-mail is about to be sent to the e-mail address below to verify it. To
            continue press the "Send Verification Link" button, otherwise update your email then verify it.</p>
        <h3 class="text-center text-muted text-bold-500">"{{$email}}"</h3>
    </div>
    <form class="form">
        <div class="form-actions center">
            <a href="{{route('ur.verifyStudent',['modify'=>"email"])}}" class="btn btn-warning mr-1">
                <i class="la la-pencil-square"></i> Change E-mail
            </a>
            <a href="{{route('ur.verifyByEmail',["type"=>"send"])}}" class="btn btn-primary">
                <i class="la la-check-square-o"></i> Send Verification Link
            </a>
        </div>
    </form>
@endsection