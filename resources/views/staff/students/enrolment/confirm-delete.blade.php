@extends("layouts.staff-master")

@section("pageTitle","Student Enrolment - Confirm Deletion")

@section("headerTitle","Student Enrolment - Confirm Deletion")

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Student Enrolment - Delete Record</h4>
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


                                <h2 class="mb-2">You are about to
                                    delete {{$offer->title}} {{$offer->first_name}} {{$offer->last_name}} with
                                    the student number <strong>{{$offer->student_no}}</strong>'s record. Press the
                                    confirm button to delete otherwise cancel.</h2>
                            </div>
                            <div class="col-md-6 offset-md-3">
                                <form class="form" method="post"
                                      action="{{route('staff.students.enrolment.delete',["base_enrolled_student"=>$offer->id])}}">
                                    @method("delete")
                                    @csrf
                                    <button type="submit" class="btn mb-2 btn-danger btn-lg btn-block">Confirm</button>
                                    <a href="{{route('staff.students.enrolment')}}"
                                       class="btn mb-2 btn-warning btn-lg btn-block">Cancel</a>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


