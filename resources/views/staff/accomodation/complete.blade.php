@extends("layouts.staff-master")

@section("pageTitle","Room Allocated")

@section("headerTitle","Accommodation - Room Allocated!")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Accommodation</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert bg-success alert-icon-left mb-2" role="alert">
                                    <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                    The room has been allocated with the following details.
                                </div>

                                @if (session('status'))
                                    <div class="alert round bg-success alert-icon-left alert-dismissible mb-2"
                                         role="alert">
                                        <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        {{session("status")}}
                                    </div>
                                @endif
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


                            </div>
                            <div class="col-md-6 offset-md-3">
                                <form class="form form-horizontal form-bordered mb-2">
                                    @php($user = $allocation->user)
                                    <div class="form-body">
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control"
                                                   for="form_control_1">Student ID</label>
                                            <div class="col-md-7 form-text text-center text-bold-700">
                                                {{(!is_null($user->student_no))?$user->student_no : "-"}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Surname</label>
                                            <div class="col-md-7 form-text text-center text-bold-700">
                                                {{$user->last_name}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">First name</label>
                                            <div class="col-md-7 form-text text-center text-bold-700">
                                                {{$user->first_name}}
                                            </div>
                                        </div>
                                        @php($bed = $allocation->bed)
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control" for="enrolment">Hostel</label>
                                            <div class="col-md-7 form-text text-center text-bold-700">
                                                {{$bed->room->hostel->name}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-5 label-control" for="level">Room</label>
                                            <div class="col-md-7 form-text text-center text-bold-700">
                                                {{$bed->room->name}}
                                            </div>
                                        </div>
                                        <div class="form-group last row">
                                            <label class="col-md-5 label-control" for="term">Bed</label>
                                            <div class="col-md-7 form-text text-center text-bold-700">
                                                {{$bed->bed_count}}
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <a href="#"
                                   class="btn mb-2 btn-success btn-lg btn-block printDiv">Print Accommodation Letter</a>
                                <a href="{{route('staff.accommodation.hostel-rooms',["hostel"=>$allocation->bed->room->hostel_id])}}"
                                   class="btn mb-2 btn-secondary btn-lg btn-block">Go Back To Accommodation Chart</a>
                            </div>
                        </div>

                        <div id="letter" class="d-none">
                            @include("staff.accomodation.accommodation-letter")
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageJavascript')

    <script>
        $(document).ready(function () {

            $('.printDiv').click(function (e) {
                e.preventDefault();
                PrintElem('letter');
            });

            function PrintElem(elem) {
                // 960×720
                // 800×600
                let mywindow = window.open('', 'PRINT', 'height=800,width=960');

                // mywindow.document.write('<html><head><title>' + document.title  + '</title>');
                // mywindow.document.write('</head><body >');
                // mywindow.document.write('<h1>' + document.title  + '</h1>');
                mywindow.document.write(document.getElementById(elem).innerHTML);
                // mywindow.document.write('</body></html>');

                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10*/

                mywindow.print();
                mywindow.close();

                return true;
            }
        });
    </script>
@endpush


