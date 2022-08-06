@extends('profile.verification-partials.base')

@section("title","Update Phone Number")

@section("content")
    <div class="card-text">
        <p class="text-center text-justify">You are now updating your phone number, please ensure that you have access
            to this phone and that it is capable of receiving texts. Phone number format must be +263771234567</p>
    </div>
    <form class="form" method="post" action="{{route('urp.updatePhone',["attribute"=>"phone-number"])}}">
        @csrf
        <div class="row">
            <div class="form-group col-12 mb-2">
                <label for="cellphone">Cellphone Number</label>
                <input type="text" id="cellphone" class="form-control" placeholder="Cellphone" name="cellphone">
            </div>
        </div>

        <div class="form-actions center">
            <a href="{{route('ur.verifyStudent')}}" class="btn btn-warning mr-1">
                <i class="ft-x"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="la la-check-square-o"></i> Update Cellphone Number
            </button>
        </div>
    </form>
@endsection