@extends('layouts.master')

@section('pageTitle',"Add Tertiary Qualification Results")

@section('mainCon')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="bordered-layout-basic-form">Update Personal Information</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                {{--<li><a data-action="collapse"><i class="ft-minus"></i></a></li>--}}
                                {{--<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>--}}
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                {{--<li><a data-action="close"><i class="ft-x"></i></a></li>--}}
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="card-text">
                                <p class="text-justify">A period is an academic session that may be
                                    called a Semester or a Term. At the last column of the table there is a button
                                    to add a period. You will not be able to proceed until a period is
                                    added.Please fill in the form with information of a period related to
                                    your tertiary qualification titled
                                    <strong>{{$qualification->qualification_title}}</strong> issued by
                                    <strong>{{$qualification->institution_name}}</strong>.</p>
                            </div>
                            @if (session('status'))
                                <div class="alert round bg-success alert-icon-left alert-dismissible mb-2" role="alert">
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
                            <form method="post"
                                  action="{{route('urp.addTertiaryPeriod',["code"=>$qualification->code])}}"
                                  class="form row">
                                {!! csrf_field() !!}

                                <div class="form-group col-md-12 mb-2">
                                    <label class="label-control" for="period">Period</label>
                                    <input type="text" class="form-control"
                                           placeholder="Period (Ex. Semester 1 Level 1)"
                                           id="period" name="period" value="{{old('period')}}">
                                </div>

                                <div class="form-group col-md-12 mb-2">
                                    <label class="label-control" for="number_of_courses">Number Of
                                        Modules/Courses</label>
                                    <input type="number" class="form-control" id="number_of_courses" min="1" max="25"
                                           name="number_of_courses" value="{{old('number_of_courses')}}">
                                </div>

                                <div class="form-group col-12 last">
                                    <a href="{{route("ur.addTertiary")}}" class="btn btn-warning mr-1">
                                        <i class="la la-arrow-circle-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Next
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascripts')
    <script src="/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"
            type="text/javascript"></script>
    <script src="/app-assets/js/scripts/forms/form-repeater.js" type="text/javascript"></script>
@endpush
