@extends("layouts.staff-master")

@section("pageTitle","Student Registered")

@section("headerTitle","Student Registration")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Student Registration</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
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


                                <h2 class="mb-2">{{$user->first_name}} {{$user->last_name}}({{$user->student_no}}) has
                                    been registered for period {{$studentRegistration->registration_period->title}},
                                    for {{$studentRegistration->student_enrolment->qualification->name}} -
                                    {{$studentRegistration->student_enrolment->programme->name}}
                                    {{--Level {{$studentRegistration->level}} Term {{$studentRegistration->term}}--}}
                                </h2>
                            </div>
                            <div class="col-md-6 offset-md-3">
                                <a href="#"
                                   class="btn mb-2 btn-success btn-lg btn-block printDiv">Print Registration Letter</a>
                                <a href="{{route('staff.student-registration.index')}}"
                                   class="btn mb-2 btn-primary btn-lg btn-block">Register another student</a>
                                {{--<a href="{{route('staff.registration.index')}}"--}}
                                {{--class="btn mb-2 btn-secondary btn-lg btn-block">Go To Registration Main Page</a>--}}
                            </div>
                        </div>

                        <div id="letter" class="d-none">
                            @include("staff.registration-period.registration-record.registration-letter")
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


