@extends('profile.verification-partials.base')

@section("title","Do you have". (($addedAlevel)?" Another ":" an ") ."A Level Certificate?")

@section("content")
    <div class="card-text">
        <p class="text-center text-justify">Do you have {{(($addedAlevel)?"another":"an")}} A Level
            Certificate? If so click on the "Add {{(($addedAlevel)?"Another":"")}} A Level Certificate" button.
            Otherwise proceed to verify the records you have added. In case you missed a record you will still be able
            to add it on the review page. If there is a wrong entry, at the end of every table there will be a "remove"
            button which if selected will allow you to remove the record. If you have verified your entries, you may
            press the "Continue" button which is an admission that your entries are accurate.</p>
    </div>
    <form class="form">
        <div class="form-actions center">
            <a href="{{route('ur.addCertificate',["cert_level"=>"A"])}}" class="btn btn-success mr-1">
                <i class="la la-certificate"></i> Add {{(($addedAlevel)?"Another":"")}} A Level Certificate
            </a>
            @php
                $parameter = request( )->input( );
                $parameter["review"] = "yes";
            @endphp
            <a href="{{route('ur.secodarySchool',$parameter)}}" class="btn btn-primary">
                <i class="la la-thumbs-up"></i> Proceed
            </a>
        </div>
    </form>
@endsection