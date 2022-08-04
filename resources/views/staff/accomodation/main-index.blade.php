@extends("layouts.staff-master")

@section("pageTitle", "Accommodation")
@section("headerTitle")
    <div class="btn-group mr-1 mb-1">
        <h2 class="my-auto mr-2">Accommodation</h2>
        <button class="btn btn-info btn-lg dropdown-toggle" type="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            Select Hostel
        </button>
        <div class="dropdown-menu">
            @foreach($hostels as $hostel)
                <a href="{{route('staff.accommodation.hostel-rooms',["hostel"=>$hostel->id])}}"
                   class="dropdown-item">{{$hostel->name}}</a>
            @endforeach
        </div>
    </div>
@endsection

@section("contenta")
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">

                        <h4 class="card-title">Accommodation - Home</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        @include("layouts.partials.notifications")
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h4>What would you like to do today?</h4>
                            </div>
                            {{--<div class="col-md-6 offset-md-3">--}}
                            {{--<a href="#"--}}
                            {{--class="btn mb-2 btn-success btn-lg btn-block">Add/View Residence Spaces</a>--}}
                                {{--<a href="{{route('staff.students.view-enrolment-edit')}}"--}}
                                {{--class="btn mb-2 btn-warning btn-lg btn-block">Edit Enrolment</a>--}}
                                {{--<a href="{{route('staff.students.get-enrolment')}}"--}}
                                {{--class="btn mb-2 btn-primary btn-lg btn-block">Reprint Enrolment Letter</a>--}}
                                <a href="{{route("staff.accommodation.hostels")}}"
                                   class="btn mb-2 btn-secondary btn-lg btn-block">View Hostels</a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push("pageJavascript")
    <script>
        $('.dropdown-toggle').dropdown();
    </script>
@endpush