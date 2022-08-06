@extends('profile.verification-partials.base')

@section("title","Update E-mail")

@section("content")
    <div class="card-text">
        <p class="text-center text-justify">You are now updating your e-mail, please ensure that you have access
            to this email. Ex. me@example.com</p>
    </div>
    <form class="form" method="post" action="{{route('urp.updatePhone',["attribute"=>"email"])}}">
        @csrf
        <div class="row">
            <div class="form-group col-12 mb-2">
                <label for="cellphone">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="E-mail" name="email">
            </div>
        </div>

        <div class="form-actions center">
            <a href="{{route('ur.verifyStudent')}}" class="btn btn-warning mr-1">
                <i class="ft-x"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="la la-check-square-o"></i> Update Email
            </button>
        </div>
    </form>
@endsection