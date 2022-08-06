@extends('profile.verification-partials.base')

@section("title","Check Verification Link")

@section("content")
    <div class="card-text">
        <p class="text-center text-justify">Please check your email for the verification link that has been sent to you.
            If there is no e-mail in your inbox, go to your spam. If the email hasn't arrived within 5 minutes press the
            Resend Email button.</p>
    </div>
    <form class="form">
        <div class="form-actions center">
            <a href="{{route('ur.verifyByEmail',["type"=>"resend"])}}" class="btn btn-block btn-secondary mr-1">
                <i class="la la-envelope"></i> Resend Verification Email
            </a>
            <a href="{{route('ur.verifyByEmail',["type"=>"go-back"])}}" class="btn btn-block btn-warning mr-1">
                <i class="la la-chevron-circle-left"></i> Back
            </a>
        </div>
    </form>
@endsection