@extends('profile.verification-partials.base')

@section("title","Enter Verification Code")

@section("content")
    <div class="card-text">
        <p class="text-center text-justify">Please provide the verification code sent to your cellphone. If an SMS with
            the verification code hasn't arrived within 5 minutes press the Resend Code button.</p>
    </div>
    <form class="form" method="post" action="{{route('urp.verifyBySMS')}}">
        @csrf
        <div class="row">
            <div class="form-group col-12 mb-2">
                <label for="verification_code">Verification Code</label>
                <div class="input-group">
                    <input class="form-control border-primary"
                           name="verification_code" type="text"
                           placeholder="Verification Code"
                           id="verification_code">
                    <div class="input-group-append">
                        <a href="{{route('ur.verifyBySMS',["type"=>"resend"])}}" class="btn btn-secondary">Resend
                            Code</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions center">
            <a href="{{route('ur.verifyBySMS',["type"=>"go-back"])}}" class="btn btn-warning mr-1">
                <i class="ft-x"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="la la-check-square-o"></i> Verify Cellphone
            </button>
        </div>
    </form>
@endsection