@extends('profile.verification-partials.base')

@section("title","Attended Another High School?")

@section("content")
    <div class="card-text">

        <p class="text-center text-justify">Did you attend another school beside the one(s) you have added? If so click
            on the "Add Another High School" button otherwise proceed on to adding your O Level Results by clicking the
            "Add O Level Results" button.</p>
    </div>
    <form class="form">
        <div class="form-actions center">
            <a href="{{route("ur.addSecondary")}}" class="btn btn-warning mr-1">
                <i class="la la-institution"></i> Add Another High School
            </a>
            <a href="{{route('ur.addCertificate',["cert_level"=>"O"])}}" class="btn btn-primary">
                <i class="la la-certificate"></i> Add O Level Results
            </a>
        </div>
    </form>
@endsection