@extends('profile.verification-partials.base')

@section("title","Report A Missing Subject")

@section("content")
    <div class="card-text">
        <p class="text-center text-justify">Please provide subject title.</p>
    </div>
    <form class="form" method="post" action="{{route('urp.addCertificateResults',["id"=>base64_encode($certs->id)])}}">
        @csrf
        <div class="row">
            <div class="form-group col-12 mb-2">
                <label for="subject">Subject</label>
                <input type="text" id="subject" class="form-control" placeholder="Subject" name="subject">
            </div>
        </div>

        <div class="form-actions center">
            <?php
            $parameter = request()->input();
            unset($parameter["opt"]);
            $parameter["id"] = base64_encode($certs->id);
            ?>
            <a href="{{route('ur.addCertificateResults',$parameter)}}" class="btn btn-warning mr-1">
                <i class="ft-x"></i> Cancel
            </a>
            <button name="missing_subject" type="submit" class="btn btn-primary">
                <i class="la la-check-square-o"></i> Submit Report
            </button>
        </div>
    </form>
@endsection