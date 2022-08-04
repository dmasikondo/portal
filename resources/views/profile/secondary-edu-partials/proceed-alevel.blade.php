@extends('profile.verification-partials.base')

@section("title","Have Another O Level Certificate?")

@section("content")
    <div class="card-text">
        <p class="text-center text-justify">Do you have another O Level certificate besides the one that you have
            already added? If you do, click on the "Add Another O Level Certificate" button. Otherwise click "Proceed"
            button.</p>
    </div>
    <form class="form">
        <div class="form-actions center">
            <a href="{{route('ur.addCertificate',["cert_level"=>"O"])}}" class="btn btn-warning mr-1">
                <i class="la la-certificate"></i> Add Another O Level Certificate
            </a>
            @php
                $parameter = request( )->input( );
                $parameter["olevel"] = "done";
            @endphp
            <a href="{{route('ur.secodarySchool',$parameter)}}" class="btn btn-primary">
                <i class="la la-thumbs-up"></i> Proceed
            </a>
        </div>
    </form>
@endsection