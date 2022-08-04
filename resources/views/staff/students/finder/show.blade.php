@extends("layouts.staff-master")

@section("pageTitle",((is_null(request('search')))?"Student Finder":"Search Results for \"".request('search')."\"..."))

@section("headerTitle",((is_null(request('search')))?"Student Finder":"Search Results for \"".request('search')."\"..."))

@section('content')
    <section class="row two-friends">
        <div class="col-4 boss-box">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Students Details</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        @if(count($errors->all()) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert round bg-danger alert-icon-left alert-dismissible mb-2"
                                     role="alert">
                                    <span class="alert-icon"><i class="la la-exclamation-triangle"></i></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {{$error}}
                                </div>
                            @endforeach
                        @endif
                        <form class="form-horizontal" method="get" novalidate>

                            <fieldset class="form-group form-group-style">
                                <label for="surname"><i class="ft-user"></i> Your Surname</label>
                                <input name="surname" type="text" class="form-control" id="surname"
                                       placeholder="Surname"
                                       value="{{old("surname")?:request("surname")}}">
                            </fieldset>

                            <fieldset class="form-group form-group-style">
                                <label for="national_id"><i class="la la-slack"></i> Your National ID</label>
                                <input name="national_id" type="text" class="form-control" id="national_id"
                                       value="{{old("national_id")?:request("national_id")}}"
                                       placeholder="99-999999X99" required>
                            </fieldset>

                            <fieldset class="form-group form-group-style">
                                <label for="student_id"><i class="ft-credit-card"></i> Your Student ID</label>
                                <input name="student_id" type="text" class="form-control" id="student_id"
                                       value="{{old("student_id")?:request("student_id")}}" placeholder="Student ID"
                                       required>
                            </fieldset>

                            <button type="submit" class="btn btn-outline-info btn-block"><i class="ft-check"></i> Check
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8 slave-box">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Results</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include('layouts.partials.notifications')

                        @if(!is_null($st_type))
                            @include("staff.students.finder.partials.s-{$st_type}")
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push("pageJavascript")
    <script>
        $(document).ready(function () {

            let $height = $('.boss-box > .card').height();
            $('.slave-box > .card').css({'min-height': $height});
        });
    </script>
@endpush


