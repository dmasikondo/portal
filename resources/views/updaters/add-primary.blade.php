@extends('layouts.master')

@section('pageTitle',"Add Primary School")

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
                                <p>Please provide details of the primary school you attended.</p>
                            </div>
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

                            @if (session('status'))
                                <div class="alert round bg-success alert-icon-left alert-dismissible mb-2" role="alert">
                                    <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {{session("status")}}
                                </div>
                            @endif
                            <form class="form form-horizontal form-bordered" method="post"
                                  action="{{route('urp.addPrimary')}}">
                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-institution"></i> Add Primary School</h4>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="school">School</label>
                                        <div class="col-md-9">
                                            <input type="text" id="school" class="form-control"
                                                   placeholder="Primary School"
                                                   name="school"
                                                   value="{{Session::hasOldInput("school")?Session::getOldInput("school"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="town">Town</label>
                                        <div class="col-md-9">
                                            <input type="text" id="town" class="form-control"
                                                   placeholder="Town"
                                                   name="town"
                                                   value="{{Session::hasOldInput("town")?Session::getOldInput("town"):""}}">
                                        </div>
                                    </div>

                                    @php($grades_arr = array_combine(range(1,7),range(1,7)))

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="from_grade">From
                                            Grade</label>
                                        <div class="col-md-9">
                                            {!! Form::select('from_grade',$grades_arr,null,["class"=>"form-control", "id"=>"from_grade"]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="to_grade">To Grade</label>
                                        <div class="col-md-9">
                                            {!! Form::select('to_grade',$grades_arr,null,["class"=>"form-control", "id"=>"to_grade"]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="from_year">Which year did you
                                            start?</label>
                                        <div class="col-md-9">
                                            {!! Form::select('from_year',
                                                    ([""=>"Year"]+array_combine(range((date('Y')),(date('Y')-110)),range((date('Y')),(date('Y')-110)))),null,['id'=>'from_year',"class"=>"form-control"]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="to_year">Which year did you
                                            finish?</label>
                                        <div class="col-md-9">
                                            {!! Form::select('to_year',
                                                  ([""=>"Year"]+array_combine(range((date('Y')),(date('Y')-110)),range((date('Y')),(date('Y')-110)))),null,['id'=>'to_year',"class"=>"form-control"]) !!}
                                        </div>
                                    </div>

                                    {{--<div class="form-group row">--}}
                                    {{--<label class="col-md-3 label-control" for=""></label>--}}
                                    {{--<div class="col-md-9">--}}
                                    {{--<input type="text" id="" class="form-control"--}}
                                    {{--placeholder=""--}}
                                    {{--name=""--}}
                                    {{--value="{{Session::hasOldInput("")?Session::getOldInput(""):""}}">--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="form-actions">
                                    <a href="{{route("ur.stage4")}}" class="btn btn-warning mr-1">
                                        <i class="la la-arrow-circle-left"></i> Back
                                    </a>
                                    <button name="save_continue" type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Save And Continue
                                    </button>

                                    <button name="save_add" type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Save And Add Another Primary School
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

